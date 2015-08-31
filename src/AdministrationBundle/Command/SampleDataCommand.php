<?php

namespace AdministrationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManager;

class SampleDataCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('sample:data')
            ->setDescription('Load sample data for local developement.')
            ->addArgument('argument', InputArgument::OPTIONAL, '¿Only delete ([delete])?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $argument = $input->getArgument('argument');

        $loremipsum = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla in tempor risus. Morbi urna purus, consectetur in varius a, volutpat vel massa. Curabitur sit amet nibh porttitor, ornare nulla at, faucibus sem. In mollis semper massa, non tempor leo tristique in. Donec commodo justo scelerisque, elementum lectus gravida, aliquet neque. Morbi at mi tellus. Suspendisse elementum, felis a aliquet vehicula, nibh tellus ultricies dui, ac sagittis dui dui vel ante. Mauris eu accumsan velit. Aenean at ultricies massa, a dignissim dui. Suspendisse ut lectus fermentum, interdum lectus non, bibendum turpis.';
        $loremipsum .= 'Phasellus suscipit blandit mauris in ultrices. Sed est ipsum, aliquam a ultrices ut, finibus vel nisi. Nulla imperdiet quam vel magna consectetur, nec pharetra metus cursus. Suspendisse mollis id ligula scelerisque hendrerit. Nunc dignissim eleifend mollis. Maecenas sed pulvinar neque. Suspendisse sed mauris dictum, ultricies justo nec, lobortis risus. Nam tellus massa, varius fringilla iaculis ac, mattis vitae est. Duis dictum mauris non nisl tristique aliquet.';
        $loremipsum .= 'Aenean at mattis urna, eu lacinia velit. Maecenas malesuada eget tortor sed feugiat. Vestibulum at diam orci. Nulla sem ipsum, mattis a tellus eget, mollis tempus arcu. Duis viverra augue eget nunc semper, sed viverra mauris elementum. Nullam et quam neque. Sed sodales porta eros vitae eleifend.';
        $loremipsum .= 'Vivamus id tortor vitae nibh dictum volutpat. Integer auctor dolor sit amet hendrerit tincidunt. Cras finibus congue urna lobortis rutrum. Ut feugiat elit ac diam efficitur, ac feugiat tortor sollicitudin. Vestibulum in odio eget mi suscipit sollicitudin et bibendum urna. Nulla quis ipsum maximus, vulputate magna eu, ultricies nibh. Nam blandit massa eget arcu mollis, vel congue augue malesuada. Pellentesque sit amet elementum dolor, nec gravida sapien. Etiam egestas lorem quis tellus vulputate placerat quis fringilla est. Donec eu lectus ac enim iaculis fermentum. Vestibulum ante felis, commodo id ullamcorper pretium, pharetra tristique odio. Nulla facilisi. Pellentesque ut nisi sollicitudin, convallis augue id, gravida risus. Quisque at convallis est. Donec ut urna pulvinar, finibus tortor vel, aliquam eros. Suspendisse consectetur convallis enim, vel dapibus lacus congue vel.';
        $loremipsum .= 'Integer volutpat turpis sed leo accumsan tempor. Integer eget venenatis purus. Nunc malesuada pulvinar semper. Proin eu nibh ligula. Proin lorem nulla, eleifend ut leo a, aliquam cursus orci. Nam est dui, rutrum sit amet nisl nec, fringilla rhoncus turpis. Cras porta fermentum ornare. Proin non porttitor nisi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Ut nec lacus semper, sagittis sapien ac, consequat sem.';

        $loremipsumshort = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla in tempor risus. Morbi urna purus, consectetur in varius a, volutpat vel massa. Curabitur sit amet nibh porttitor, ornare nulla at, faucibus sem. In mollis semper massa, non tempor leo tristique in. Donec commodo justo scelerisque, elementum lectus gravida, aliquet neque. Morbi at mi tellus. Suspendisse elementum, felis a aliquet vehicula, nibh tellus ultricies dui, ac sagittis dui dui vel ante. Mauris eu accumsan velit. Aenean at ultricies massa, a dignissim dui. Suspendisse ut lectus fermentum, interdum lectus non, bibendum turpis.';

        $manager = $this->getContainer()
            ->get('doctrine')
            ->getManager();

        if ($argument == 'delete') {
            // only deleting sample data
            $this->deleteAll($manager, $output);
        } else {
            $this->deleteAll($manager, $output);

            $output->write('loading data.. ');
        }

        $manager->flush();

        $output->writeln('ok');
    }

    private function deleteAll(EntityManager $manager, OutputInterface $output)
    {
        $output->write('Deleting sample data.. ');

        $manager->flush();
    }
}
