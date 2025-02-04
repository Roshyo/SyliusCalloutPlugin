<?php

declare(strict_types=1);

namespace Setono\SyliusCalloutPlugin\Callout\Checker\Rule;

use Setono\SyliusCalloutPlugin\Model\CalloutsAwareInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Promotion\Exception\UnsupportedTypeException;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;
use Webmozart\Assert\Assert;

final class HasTaxonCalloutRuleChecker implements ProductCalloutRuleCheckerInterface
{
    public const TYPE = 'has_taxon';

    private TaxonRepositoryInterface $taxonRepository;

    public function __construct(TaxonRepositoryInterface $taxonRepository)
    {
        $this->taxonRepository = $taxonRepository;
    }

    public function isEligible(CalloutsAwareInterface $product, array $configuration): bool
    {
        if (!$product instanceof ProductInterface) {
            throw new UnsupportedTypeException($product, ProductInterface::class);
        }

        Assert::keyExists($configuration, 'taxons');

        /** @var TaxonInterface[] $taxons */
        $taxons = $this->taxonRepository->findBy(['code' => $configuration['taxons']]);

        foreach ($taxons as $taxon) {
            if ($product->getMainTaxon() === $taxon || $product->hasTaxon($taxon)) {
                return true;
            }
        }

        return false;
    }
}
