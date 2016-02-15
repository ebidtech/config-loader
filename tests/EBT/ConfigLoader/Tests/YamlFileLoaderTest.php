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
 *
 * @coversDefaultClass EBT\ConfigLoader\YamlFileLoader
 */
class YamlFileLoaderTest extends TestCase
{
    /**
     * @var vfsStreamDirectory
     */
    private $root;

    /**
     * Tests failure case when trying to load an invalid file (not a regular file).
     *
     * @expectedException \EBT\ConfigLoader\Exception\InvalidArgumentException
     * @expectedExceptionMessage not a regular file
     *
     * @covers ::load
     */
    public function testLoadInvalidFile()
    {
        (new YamlFileLoader())->load(vfsStream::url('test'));
    }

    /**
     * Tests failure case when trying to load an unreadable file.
     *
     * @expectedException \EBT\ConfigLoader\Exception\InvalidArgumentException
     * @expectedExceptionMessage not readable
     *
     * @covers ::load
     */
    public function testLoadFileNotReadable()
    {
        $this->root->addChild(vfsStream::newFile('file1'));

        /* Make sure is not readable. */
        $this->root->getChild('file1')->chown('testuser')
            ->chgrp('testuser')
            ->chmod(0750);

        (new YamlFileLoader())->load(vfsStream::url('test/file1'));
    }

    /**
     * Tests failure case when loaded file does not contain valid YAML.
     *
     * @expectedException \EBT\ConfigLoader\Exception\InvalidArgumentException
     * @expectedExceptionMessage Could not parse Yaml
     *
     * @covers ::load
     */
    public function testLoadFileNotYaml()
    {
        vfsStream::create(['file1' => 'test'], $this->root);

        (new YamlFileLoader())->load(vfsStream::url('test/file1'));
    }

    /**
     * Tests success case for loading a valid and readable YAML file.
     *
     * @covers ::load
     */
    public function testLoad()
    {
        $initialContent = ['hello' => 'world'];
        $ymlContent     = Yaml::dump($initialContent);

        vfsStream::create(['file1' => $ymlContent], $this->root);

        $this->assertEquals($initialContent, (new YamlFileLoader())->load(vfsStream::url('test/file1')));
    }

    /**
     * Tests success and failure cases for supports method.
     *
     * @covers ::supports
     */
    public function testSupports()
    {
        $yamlLoader = (new YamlFileLoader());

        $this->assertFalse($yamlLoader->supports('test.txt'));
        $this->assertFalse($yamlLoader->supports('test.json'));
        $this->assertTrue($yamlLoader->supports('test.yml'));
    }

    /**
     * Tests success case for loading a valid and readable YAML file (using real file).
     *
     * @covers ::load
     */
    public function testLoadYamlFile()
    {
        $yamlLoader = new YamlFileLoader();
        $content    = $yamlLoader->load(__DIR__ . '/test.yml');
        $this->assertEquals(
            ['justatest' => ['bla' => 'val', 'bla2' => 'val2']],
            $content
        );
    }

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
}
