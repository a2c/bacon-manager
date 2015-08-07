<?php

namespace A2C\Bundle\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Faker\Factory;

/**
 * Class FakerCommand
 *
 * @package AppBundle\Command
 * @author Adan Felipe Medeiros<adan.grg@gmail.com>
 * @version 1.0
 */
class FakerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('a2c:faker:populate')
            ->setDescription('Gera dados para testes de entidades')
            ->addArgument(
                'env',
                InputArgument::OPTIONAL,
                'Qual a o ambiente que deve executar a rotina'
            )
            ->addOption('qtd','quantidade',InputOption::VALUE_REQUIRED);
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $number = (int) $input->getOption('qtd');

        if ($number == 0) {
            throw new \Exception("Passar quantidade como paramentro");
        }

        $em = $this->getContainer()->get('doctrine')->getManager();

        $entities = array();

        $metaFactory = $em->getMetadataFactory()->getAllMetadata();

        foreach ($metaFactory as $meta) {
            $entities[] = $meta->getName();
        }

        $entities[] = 'no';

        $validation = function ($entity) use ($entities) {

            if (!in_array($entity, array_values($entities))) {
                throw new \InvalidArgumentException(sprintf('A entity "%s" não é valida.', $entity));
            }

            return $entity;
        };

        $dialog = $this->getHelperSet()->get('dialog');

        while (true) {
            $returnEntity = $dialog->askAndValidate($output, '<info>Deseja remover alguma entidade? [no] : </info>', $validation, false, 'no', $entities);

            if ($returnEntity == 'no')
                break;

            if(in_array($returnEntity, array_values($entities))) {
                unset ($entities[array_search($returnEntity,$entities)]);
            }

            $output->writeln(sprintf('Você removeu a entidade: %s', $returnEntity));
        }

        //Remove a opção no do array autocomplete
        unset ($entities[array_search('no',$entities)]);

        $output->writeln("<comment>========== PROCESSANDO O FAKER ===========</comment>");

        $generator = Factory::create();

        $populate = new \Faker\ORM\Doctrine\Populator($generator,$this->getContainer()->get('doctrine')->getManager());

        foreach ($entities as $entity) {
            $populate->addEntity($entity,$number);
        }

        $populate->execute();

        $output->writeln("<comment>========== FINALIZADO ====================</comment>");

    }
}
