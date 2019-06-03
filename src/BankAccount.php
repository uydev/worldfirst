<?php

namespace WorldFirst\BankAccount;

class BankAccount {


    /**
     * @var
     */
    private $accountName;

    /**
     * @var int
     */
    private $balance;

    /**
     * @var int
     */
    private $overdraftLimit;

    /**
     * @var bool
     */
    private $overdraftApplied;

    /**
     * @var bool
     */
    private $accountStatus;

    /**
     * BankAccount constructor.
     * @param $accountName
     * @param int $balance
     * @param int $overdraftLimit
     * @param bool $overdraftApplied
     * @param bool $accountStatus
     */
    public function __construct($accountName, $balance = 0, $overdraftLimit = 0, $overdraftApplied = false, $accountStatus = true)
    {
        $this->accountName = $accountName;
        $this->balance = $balance;
        $this->overdraftLimit = $overdraftLimit;
        $this->overdraftApplied = $overdraftApplied;
        $this->accountStatus = true;

        echo 'Bank Account created with account owner:'.$accountName;
        echo "\n";

    }

    /**
     * @param $amount
     */
    public function depositFunds($amount)
    {
        $this->balance += $amount;
		echo '£'.$amount. ' has been deposited';
		echo "\n\n";
    }

    /**
     * @param $amount
     * @return string
     */
    public function withdrawFunds($amount){

        if (($this->balance > 0) && ($this->balance>= $amount)){
            $this->balance -= $amount;
			echo '£'.$amount.' has been withdrawn';
			echo "\n\n";
        }
        else if ($this->overdraftApplied && ($amount <= ($this->balance+$this->overdraftLimit))) {
            echo 'You are using from your overdraft allowance!';
            echo "\n\n";
            $this->balance -= $amount;
			echo '£'.$amount. ' has been withdrawn';
			echo "\n\n";
        }
        else {
            return 'Insufficient funds';
            echo "\n";
        }
    }

    /**
     * @return int
     */
    public function getBalance(){
       return $this->balance;
    }

    /**
     * @param $choice
     */
    public function enableOverdraft($choice){

        if($this->overdraftApplied == false) {
            $this->overdraftApplied = $choice;
            echo 'Overdraft has been enabled for this account';
            echo "\n";
        }
        else {
            echo 'Overdraft has already been enabled for this account';
            echo "\n";
        }
    }

    /**
     * @param $choice
     */
    public function disableOverdraft($choice) {
        if($this->overdraftApplied) {
            $this->overdraftApplied = $choice;
            echo 'Overdraft has been disabled for this account';
            echo "\n";
        }
        else {
            echo 'Overdraft has already been disabled for this account';
            echo "\n";
        }
    }

    /**
     * @return int
     */
    public function getOverdraftLimit()
    {
        return $this->overdraftLimit;
    }

    /**
     * @return bool
     */
    public function isOverdraftApplied()
    {
        if($this->overdraftApplied)
            return 'enabled';
        else
            return 'disabled';
    }

    /**
     * Sets accountStatus to false
     */
    public function closeAccount()
    {
        $this->accountStatus = false;
    }

    /**
     * @return bool
     */
    public function getAccountStatus() {
        return $this->accountStatus;
    }
}