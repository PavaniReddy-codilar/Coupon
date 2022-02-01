<?php


namespace Codilar\Coupon\Model\Resolver;


use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Query\Resolver\ValueFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\SalesRule\Api\Data\CouponInterface;
use Magento\SalesRule\Api\CouponRepositoryInterface;

class Coupon implements ResolverInterface
{
    const KEY_CODE = 'code';
    /**
     * @var ValueFactory
     */
    private $valueFactory;

    /**
     * Details constructor.
     * @param ValueFactory $valueFactory
     */

    public function __construct(
        ValueFactory $valueFactory,
        \Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory $collectionFactory

    )
    {

        $this->collectionFactory = $collectionFactory;



    }

    /**
     * Fetches the data from persistence models and format it according to the GraphQL schema.
     *
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return Value|mixed
     * @throws \Exception
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $s= $this->collectionFactory->create()->addFieldToFilter('is_active', 1);
        return $s->getItems();
    }
}
