<?php

/*
 * This file is a part of the Config loader library.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\ConfigLoader\Tests;

use EBT\ConfigLoader\YamlFileLoader;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use Symfony\Component\Yaml\Yaml;

/**
 * YamFileLoaderTest
 */
class YamlFileLoaderTest extends TestCase
{
    /**
     * @var vfsStreamDirectory
     */
    private $root;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->root = vfsStream::setup('test');
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        $this->root = null;

        parent::tearDown();
    }

    /**
     * @expectedException \EBT\ConfigLoader\Exception\InvalidArgumentException
     * @expectedExceptionMessage not a regular file
     */
    public function testLoadInvalidFile()
    {
        (new YamlFileLoader())->load(vfsStream::url('test'));
    }

    /**
     * @expectedException \Symfony\Component\Yaml\Exception\ParseException
     */
    public function testLoadFileNotReadable()
    {
        $this->root->addChild(vfsStream::newFile('file1'));

        // make sure is not readable
        $this->root->getChild('file1')->chown('testuser')
             ->chgrp('testuser')
             ->chmod(0750);

        (new YamlFileLoader())->load(vfsStream::url('test/file1'));
    }

    /**
     * @expectedException \EBT\ConfigLoader\Exception\InvalidArgumentException
     */
    public function testLoadFileNotYaml()
    {
        vfsStream::create(array('file1' => 'test'), $this->root);

        (new YamlFileLoader())->load(vfsStream::url('test/file1'));
    }

    public function testLoad()
    {
        $initialContent = array('hello' => 'world');
        $ymlContent = Yaml::dump($initialContent);

        vfsStream::create(array('file1' => $ymlContent), $this->root);

        $this->assertEquals($initialContent, (new YamlFileLoader())->load(vfsStream::url('test/file1')));
    }

    public function testSupports()
    {
        $yamlLoader = (new YamlFileLoader());

        $this->assertFalse($yamlLoader->supports('test.txt'));
        $this->assertFalse($yamlLoader->supports('test.json'));
        $this->assertTrue($yamlLoader->supports('test.yml'));
    }

    public function testLoadYamlFile()
    {
        $yamlLoader = new YamlFileLoader();
        $content = $yamlLoader->load(__DIR__ . '/test.yml');
        $this->assertEquals(
            array('justatest' => array('bla' => 'val', 'bla2' => 'val2')),
            $content
        );
    }
}
