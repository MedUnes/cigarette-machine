<h1 align="center">
Cigarette Machine
    <br>
    <img src="https://github.com/medunes/cigarette-machine/blob/master/logo.png" width="200">
</h1>


[![Build Status](https://github.com/medunes/cigarette-machine/workflows/build/badge.svg?style=flat-square)](https://github.com/MedUnes/cigarette-machine/actions?query=workflow%3A%22build%22)
[![Author](https://img.shields.io/badge/author-@medunes-blue.svg?style=flat-square)](http://medunes.net)
[![codecov](https://codecov.io/gh/medunes/cigarette-machine/branch/master/graph/badge.svg)](https://codecov.io/gh/medunes/cigarette-machine/branch)
[![PHPStan](https://img.shields.io/badge/PHPStan-Level%205-brightgreen.svg?style=flat&logo=php)](https://shields.io/#/)
[![Psalm](https://img.shields.io/badge/Psalm-Level%205-brightgreen.svg?style=flat&logo=php)](https://shields.io/#/)
[![Psalm Coverage](https://shepherd.dev/github/MedUnes/cigarette-machine/coverage.svg)](https://shepherd.dev/github/MedUnes/cigarette-machine/coverage.svg)


### Setup
System requirements:
- PHP 7.4
- Composer

### Intro
Hi and welcome to limango! You're now going to participate in
a short coding test to test to your ability to think logical, 
to work independently with a given situation or environment and
develop in a smart, goal-oriented way.

### Task
Your product owner has given you the task of developing a
small CLI cigarette machine. The input should be the amount
of packs a potential customer could want and the amount he is
going to give. The price per cigarette pack is a static -4,99€.
You *dont* have to think about currencies, there are only €!

The result should be printed on the screen with the count and 
the total amount of the purchased packs as well as a table 
which tells the customer in which coin combination he is going
to get his change.

Example:

```
╭─vicgey@limango:/home
╰─$ php bin/console purchase-cigarettes 2 10.00

You bought 2 packs of cigarettes for -9,98€, each for -4,99€.

Your change is:
+-------+-------+
| Coins | Count |
+-------+-------+
| 0.02  | 1     |
+-------+-------+
```

#### Pitfalls
Think of scenarios like "less money given than total cost of
amount" and please use the predefined project structure 
(command,interfaces etc.)
