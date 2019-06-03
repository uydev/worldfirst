<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use WorldFirst\BankAccount;

require_once 'BankAccount.php';

/**
 * @covers BankAccount
 */
final class BankAccountTest extends TestCase
{
    private $ba;

    public function setup()
    {
      $this->ba = new BankAccount\BankAccount('John Smith',100,100,0, false);
    }

    public function testDepositCanBeMadeToAccount()
    {
        $this->ba = new BankAccount\BankAccount('John Smith',100,100,0, false);
        $deposit = 20;
        $result = $deposit + $this->ba->getBalance();
        $this->ba->depositFunds($deposit);
        $this->assertEquals($result, $this->ba->getBalance());
    }

    public function testWithdrawalCanBeMadeFromAccount()
    {
        $this->ba = new BankAccount\BankAccount('John Smith',100,0, false);
        $withdrawal = 30;
        $result = $this->ba->getBalance() - $withdrawal;
        $this->ba->withdrawFunds($withdrawal);
        $this->assertLessThanOrEqual($result, $this->ba->getBalance());
    }

    public function testBalanceCanBeDisplayed(){
        $balance = 100;
        $this->ba->getBalance();
        $this->assertEquals($balance, $this->ba->getBalance());
    }


    public function testWithdrawalAboveBalanceCanBeMadeWithOverdraftEnabled()
    {
        $this->ba = new BankAccount\BankAccount('John Smith',100,80, true);
        $amount = 180;
        $total = $this->ba->getBalance() + $this->ba->getOverdraftLimit();
        $expected = $total - $amount;
        $result = $this->ba->withdrawFunds($amount);
        $this->assertLessThanOrEqual($expected, $result);
    }

    public function testWithdrawalAboveBalanceAndOverdraftTotalCannotBeMade()
    {
        $this->ba = new BankAccount\BankAccount('John Smith',100,80, false);
        $amount = 220;
        $this->ba->withdrawFunds($amount);
        $this->assertSame('Insufficient funds', $this->ba->withdrawFunds($amount));
    }



    public function testOverdraftCanBeApplied() {
        $this->ba = new BankAccount\BankAccount('John Smith',100,80, false);
        $choice = true;
        $this->ba->enableOverdraft($choice);
        $this->assertSame('enabled', $this->ba->isOverdraftApplied());
    }

    public function testOverdraftCanBeDisabled() {
        $this->ba = new BankAccount\BankAccount('John Smith',100,80, false);
        $choice = true;
        $this->ba->disableOverdraft($choice);
        $this->assertSame('disabled', $this->ba->isOverdraftApplied());
    }


}