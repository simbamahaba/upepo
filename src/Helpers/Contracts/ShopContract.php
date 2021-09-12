<?php
namespace Simbamahaba\Upepo\Helpers\Contracts;
use \Illuminate\Database\Eloquent\Model;
interface ShopContract
{
    public function __construct( Model $category, Model $product);

    public function breadcrumbs( $category , $class = 'bcrumbs', &$parents='' );

    public function priceWithoutVAT( $price );

    public function formatPrice($amount, $currency = 'lei');

    public function getSubcategories( $parentId, &$subcategoriesArray=[] );

    public function categoryModel();

    public function productModel();

    public function singleProduct( $productId );

    public function categoryProducts( $categoryId, $subcategoryProducts = true, $limit = null, $paginate = null, array $orderBy = [] );

    public function allProducts( $paginate = 20, $orderBy = 'created_at' , $direction = 'asc' );

    public function randomCategoryProducts( $categoryId , $limit = null, $skipProductId = null, $subcategoryProducts = true );

    public function randomProducts( $limit = null );

    public function existingCategories();

    public function validCategory( $categoryId );
}