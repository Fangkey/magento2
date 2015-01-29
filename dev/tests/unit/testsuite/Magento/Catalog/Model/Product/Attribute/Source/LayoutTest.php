<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Catalog\Model\Product\Attribute\Source;

use Magento\TestFramework\Helper\ObjectManager as ObjectManagerHelper;

class LayoutTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Magento\Catalog\Model\Product\Attribute\Source\Layout */
    protected $layoutModel;

    /** @var ObjectManagerHelper */
    protected $objectManagerHelper;

    /** @var \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface
     * |\PHPUnit_Framework_MockObject_MockObject */
    protected $pageLayoutBuilder;

    protected function setUp()
    {
        $this->pageLayoutBuilder = $this->getMockBuilder(
            'Magento\Framework\View\Model\PageLayout\Config\BuilderInterface'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->objectManagerHelper = new ObjectManagerHelper($this);
        $this->layoutModel = $this->objectManagerHelper->getObject(
            'Magento\Catalog\Model\Product\Attribute\Source\Layout',
            [
                'pageLayoutBuilder' => $this->pageLayoutBuilder
            ]
        );
    }

    public function testGetAllOptions()
    {
        $expectedOptions = [
            '0' => ['value' => '', 'label' => 'No layout updates'],
            '1' => ['value' => 'option_value', 'label' => 'option_label'],
        ];
        $mockPageLayoutConfig = $this->getMockBuilder('Magento\Framework\View\PageLayout\Config')
            ->disableOriginalConstructor()
            ->getMock();
        $mockPageLayoutConfig->expects($this->any())
            ->method('toOptionArray')
            ->will($this->returnValue(['0' => $expectedOptions['1']]));

        $this->pageLayoutBuilder->expects($this->once())
            ->method('getPageLayoutsConfig')
            ->will($this->returnValue($mockPageLayoutConfig));

        $layoutOptions = $this->layoutModel->getAllOptions();
        $this->assertEquals($expectedOptions, $layoutOptions);
    }
}
