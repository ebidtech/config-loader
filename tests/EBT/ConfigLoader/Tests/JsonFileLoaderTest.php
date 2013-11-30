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

use EBT\ConfigLoader\JsonFileLoader;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

/**
 * JsonFileLoaderTest
 */
class JsonFileLoaderTest extends TestCase
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
        (new JsonFileLoader())->load(vfsStream::url('test'));
    }

    /**
     * @expectedException \EBT\ConfigLoader\Exception\InvalidArgumentException
     * @expectedExceptionMessage not readable
     */
    public function testLoadFileNotReadable()
    {
        $this->root->addChild(vfsStream::newFile('file1'));

        // make sure is not readable
        $this->root->getChild('file1')->chown('testuser')
                                      ->chgrp('testuser')
                                      ->chmod(0750);

        (new JsonFileLoader())->load(vfsStream::url('test/file1'));
    }

    /**
     * @expectedException \EBT\ConfigLoader\Exception\InvalidArgumentException
     * @expectedExceptionMessage cannot be json decode
     */
    public function testLoadFileNotJson()
    {
        vfsStream::create(array('file1' => 'some content'), $this->root);

        (new JsonFileLoader())->load(vfsStream::url('test/file1'));
    }

    public function testLoad()
    {
        $initialContent = array('some content');
        vfsStream::create(array('file1' => json_encode($initialContent)), $this->root);

        $content = (new JsonFileLoader())->load(vfsStream::url('test/file1'));
        $this->assertEquals($initialContent, $content);
    }

    public function testSupports()
    {
        $jsonLoader = (new JsonFileLoader());

        $this->assertFalse($jsonLoader->supports('test.txt'));
        $this->assertTrue($jsonLoader->supports('test.json'));
        $this->assertFalse($jsonLoader->supports('test.yml'));
    }

    public function testLoadJsonFile()
    {
        $yamlLoader = (new JsonFileLoader());
        $content = $yamlLoader->load(__DIR__ . '/test.json');
        $this->assertEquals(
            array('justatest' => array('bla' => 'val', 'bla2' => 'val2')),
            $content
        );
    }
}
