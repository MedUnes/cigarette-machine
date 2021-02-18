<?php

declare(strict_types=1);

namespace App\Command;

use App\Machine\ChangeCalculator;
use App\Machine\CigaretteMachine;
use App\Transaction\PurchaseTransaction;
use App\Transaction\PurchaseTransactionValidator;
use function str_replace;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/** @codeCoverageIgnore  */
class PurchaseCigarettesCommand extends Command
{
    /**
     * @return void
     */
    protected static $defaultName = 'purchase-cigarettes 2 10.00';

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->addArgument('packs', InputArgument::REQUIRED, 'How many packs do you want to buy?');
        $this->addArgument('amount', InputArgument::REQUIRED, 'The amount in euro.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $amount = $input->getArgument('amount') ?: "0";
        $itemCount = (int)$input->getArgument('packs');
        $paidAmount = (float)str_replace(',', '.', $amount);

        $cigaretteMachine = new CigaretteMachine(new ChangeCalculator(), new PurchaseTransactionValidator());
        $purchaseTransaction = new PurchaseTransaction($itemCount, $paidAmount);
        $purchasedItem = $cigaretteMachine->execute($purchaseTransaction);

        $output->writeln(sprintf(
            'You bought <info>%s</info> packs of cigarettes for <info>%s</info>, each for <info>%s</info>. ',
            $purchasedItem->getItemQuantity(),
            $purchasedItem->getTotalAmount(),
            CigaretteMachine::ITEM_PRICE
        ));
        $output->writeln('Your change is:');

        (new Table($output))->setHeaders(['Coins', 'Count'])->setRows($purchasedItem->getChange())->render();

        return Command::SUCCESS;
    }
}
