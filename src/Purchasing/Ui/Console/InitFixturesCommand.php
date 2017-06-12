<?php

namespace Selleet\Purchasing\Ui\Console;

use Psr\Container\ContainerInterface;
use Selleet\Purchasing\Domain\Cart\Cart;
use Selleet\Purchasing\Domain\Cart\CartId;
use Selleet\Purchasing\Domain\Cart\CartRepository;
use Selleet\Purchasing\Domain\Jewel\Jewel;
use Selleet\Purchasing\Domain\Jewel\JewelId;
use Selleet\Purchasing\Domain\Jewel\JewelRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

final class InitFixturesCommand extends Command
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('selleet:init')
            ->setDescription('Init fixtures')
            ->setHelp('Adds some jewels and initializes a new cart session.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Clean event stores? ', false);

        if ($helper->ask($input, $output, $question)) {
            $output->writeln(shell_exec('make clear-stores'));
        }

        $cartId = CartId::generate();

        $this->container->get(CartRepository::class)->save(Cart::pickUp($cartId));

        $output->writeln("Cart with id {$cartId->toString()} picked up.");

        for ($i = 0; $i < 10; $i++) {
            $jewelId = JewelId::generate();

            $this->container->get(JewelRepository::class)->save(
                Jewel::titledAndPriced($jewelId, 'Jewel '.$i, random_int(50, 500))
            );

            $output->writeln("Jewel with id {$jewelId->toString()} added.");
        }
    }
}
