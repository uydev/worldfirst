<?php
declare(strict_types=1);

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use WorldFirst\BankAccount\BankAccount;


class WorldFirstMenuCommand extends Command
{
    /**
     * @var SymfonyStyle
     */
    private $io;

    /**
     * MenuCommand constructor.
     * @param null $name
     */
    public function __construct($name = null)
    {
        parent::__construct('menu');

        $this->setDescription('World First Menu Command');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);

        $this->io->writeln('Create Account');
        $accountName = $this->io->ask('Account holders name:');
        $balance = (int)$this->io->ask('Balance(£)');
        $overdraftLimit = (int)$this->io->ask('Overdraft Limit?(£)');
        $overdraftApplied = $this->overdraftQuestion();

        $account = new BankAccount($accountName, $balance, $overdraftLimit, $overdraftApplied);

        $choices = ['A' => 'Deposit Money', 'B' => 'Withdraw Money', 'C'=>'Display Balance', 'D'=>'Apply Overdraft', 'E' => 'Get Overdraft Limit', 'F' => 'Is Overdraft Enabled?','G' => 'Close Account', false=>'Exit Application'];

        echo "\n";

        $choice = $this->io->choice('Please choose from the menu', $choices);

        while ($choice) {

            if ($account->getAccountStatus() == false) {
                echo "\n";
                echo 'Account was terminated. Please type: "php application.php menu to create a new account"';
                break;
            }


            $output->write(sprintf("\033\143"));

            $method = 'option' . $choice;

            $this->$method($account);

            $choice = $this->io->choice('Please choose from the menu', $choices);

            echo "\n";

        }

        return null;

    }

    /**
     * @param BankAccount $account
     */
    private function optionA(BankAccount $account)
    {
        $this->io->writeln('Deposit Money(£)');
        $amount = (int)$this->io->ask('How much would you like to deposit into your account?');
        $account->depositFunds($amount);

    }

    /**
     * @param BankAccount $account
     */
    private function optionB(BankAccount $account)
    {
        $this->io->writeln('Withdraw Money(£)');
        $amount = (int)$this->io->ask('How much would you like to withdraw from your account?');
        $account->withdrawFunds($amount);
    }

    /**
     * @param BankAccount $account
     */
    private function optionC(BankAccount $account)
    {
        $this->io->writeln('Your Balance(£)');
        echo $account->getBalance();
    }

    /**
     * @param BankAccount $account
     */
    private function optionD(BankAccount $account)
    {
        $overdraftApplied = $this->overdraftQuestion();
        $account->enableOverdraft($overdraftApplied);

    }

    /**
     * @param BankAccount $account
     */
    private function optionE(BankAccount $account)
    {
        $this->io->writeln('Get overdraft limit');

        echo $account->getOverdraftLimit();

    }

    /**
     * @param BankAccount $account
     */
    private function optionF(BankAccount $account)
    {
        $this->io->writeln('Is overdraft enabled?');
        echo $account->isOverdraftApplied();

    }

    /**
     * @param BankAccount $account
     */
    private function optionG(BankAccount $account)
    {
        $choice = $this->io->choice('Are you sure you like to terminate this account?', ['Y'=>'Yes', 'N'=>'No']);
        if ($choice == 'Y' || $choice =='Yes')
            $account->closeAccount();
        else
            return;
    }

    /**
     * @return bool
     */
    private function overdraftQuestion() {
        $choices = ['Y'=>'Yes', 'N'=>'No'];
        $choice = $this->io->choice('Would you like to apply overdraft?', $choices);
        $overdraftApplied = $choice === 'Y' ? true:false;

        return $overdraftApplied;
    }

}
