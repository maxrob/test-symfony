<?php

namespace ApiBundle\Command;

use ApiBundle\Entity\Food;
use ApiBundle\Entity\Nutrient;
use ApiBundle\Service\ConvertService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCSVCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('import:csv')
            ->setDescription('...')
            ->addArgument('file', InputArgument::OPTIONAL, 'Add a CSV file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $countLine = $this->import($input, $output);
        $output->writeln('Create '.$countLine.' foods');
    }

    protected function import(InputInterface $input, OutputInterface $output)
    {
        $data = $this->get($input);
        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->getConnection()->getConfiguration()->setSQLLogger(null);

        $size = count($data);
        $batchSize = 20;
        $i = 1;

        $progress = new ProgressBar($output, $size);
        $progress->start();

        foreach ($data as $row) {

            $food = new Food();
            $food->setOriggpcd(utf8_encode($row['ORIGGPCD']));
            unset($row['ORIGGPCD']);
            $food->setOriggpfr(utf8_encode($row['ORIGGPFR']));
            unset($row['ORIGGPFR']);
            $food->setOrigfdcd(utf8_encode($row['ORIGFDCD']));
            unset($row['ORIGFDCD']);
            $food->setOrigfdnm(utf8_encode($row['ORIGFDNM']));
            unset($row['ORIGFDNM']);
            $em->persist($food);

            foreach ($row as $title => $value) {
                preg_match('/(.*)\((.*)\)/', $title, $matches);

                $nutrient = new Nutrient();
                $nutrient->setLabel(utf8_encode($matches[1]));
                $nutrient->setMeasured(utf8_encode($matches[2]));
                $nutrient->setValue(($value !== "-") ? $value : null);
                $nutrient->setFood($food);
                $em->persist($nutrient);
            }

            if($i%$batchSize === 0) {
                $progress->advance($batchSize);
                $em->flush();
                $em->clear();
            }
            $i++;

        }
        $em->flush();
        $progress->finish();
        
        return $size;
    }

    protected function get(InputInterface $input)
    {
        $filename = $input->getArgument('file') ?: './database/Table_Ciqual_2016.csv';
        $converter = new ConvertService();
        
        return $converter->csv_to_array($filename);
    }

}
