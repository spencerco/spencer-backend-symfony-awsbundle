<?php
/**
 * This file is part of lib_serverside_awsbundle.
 *
 * (c) 2016 November Five BVBA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NovemberFive\AwsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * This command makes it possible to manually send a message to SQS
 *
 * Class SendMessageToSQSCommand
 * @package NovemberFive\AwsBundle\Command
 */
class SendMessageToSQSCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('november-five:aws:send-message-to-sqs')
            ->addArgument('message', InputArgument::REQUIRED, 'Message')
            ->addArgument('queue', InputArgument::REQUIRED, 'Queue name')
            ->addOption('is-encrypted', null, InputOption::VALUE_NONE, 'Encrypt message')
            ->addOption('is-command', null, InputOption::VALUE_NONE, 'If the message is a symfony command')
            ->setDescription('Send test message to sqs')->setHelp(<<<EOT
The <info>%command.name%</info> will send a given message to a given queue name:

    <info>php %command.full_name%</info> "message" your-queue-name

You can also send it as an encrypted message (KMS needs to be configured for this)

    <info>php %command.full_name%</info> message your-queue-name --is-encrypted

If the message that you are sending is a Symfony command you can also add the option --is-command. This will automatically put the message in json wrapped with the command key

    <info>php %command.full_name%</info> message your-queue-name --is-command


EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // feedback
        $output->writeln('<info>Start sending......</info>');

        // get the message
        $message = $input->getArgument('message');

        // wrap the message in a command array and encode it as json
        if ($input->getOption('is-command')) {
            // create sqs message
            $message = json_encode(
                array('command' => $input->getArgument('message'))
            );
        }

        // get sqs manager
        $sqsManager = $this->getContainer()->get('november_five_aws.sqs_manager');

        // send encrypted if option is set
        if ($input->getOption('is-encrypted')) {
            // send encrypted message to the given sqs queue
            $sqsManager->sendEncryptedMessage($message, $input->getArgument('queue'));
        } else {
            // send message to the given sqs queue
            $sqsManager->sendMessage($message, $input->getArgument('queue'));
        }

        // done
        $output->writeln('<info>SQS sent!</info>');
    }
}