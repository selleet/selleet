<?php

namespace Selleet\Purchasing\Ui\Console;

use Psr\Container\ContainerInterface;
use Selleet\BuildingBlocks\Command\Bus\CommandBus;
use Selleet\Purchasing\App\Cart\AddJewelToCart;
use Selleet\Purchasing\Domain\Cart\CartId;
use Selleet\Purchasing\Domain\Jewel\JewelId;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

final class AddJewelToCartCommand extends Command
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
            ->setName('selleet:add-jewel-to-cart')
            ->setDescription('Adds jewel to cart');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $cartIdAnswer = $helper->ask($input, $output, new Question('Cart id: '));
        $cartId = CartId::fromString($cartIdAnswer);

        $jewelIdAnswer = $helper->ask($input, $output, new Question('Jewel id: '));
        $jewelId = JewelId::fromString($jewelIdAnswer);

        $this->container->get(CommandBus::class)->dispatch(new AddJewelToCart(
            $cartId, $jewelId, 100
        ));

        $output->writeln('Done.');
    }
}
