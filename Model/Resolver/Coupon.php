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
         CollectionProcessorInterface $collectionProcessor = null,
        CouponRepositoryInterface $couponRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
                \Magento\SalesRule\Model\ResourceModel\Coupon\CollectionFactory $salesRuleCoupon
    )
    {
        $this->valueFactory = $valueFactory;
        $this->couponRepository = $couponRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_salesRuleCoupon = $salesRuleCoupon;


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

        $searchCriteria = $this->searchCriteriaBuilder->create();
        try {
            $couponList = $this->couponRepository->getList($searchCriteria);
            if ($couponList->getTotalCount()) {
                $couponData = $couponList->getItems();
            }

        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage());
        }
        return $couponData;
    }
}
