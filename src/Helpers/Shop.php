<?php
namespace Simbamahaba\Upepo\Helpers;

use Simbamahaba\Upepo\Helpers\Contracts\ShopContract;
use \Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
class Shop implements ShopContract
{
    private $category;
    private $items;

    public function __construct(Model $category =  null, Model $product = null)
    {
        $this->category = $category;
        $this->items = $product;
    }

    public function formatPrice($amount, $currency = 'lei')
    {
        $locale = config('app.locale');
        $formatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
        $currency = strtoupper($currency);
        return $formatter->formatCurrency($amount, $currency);
    }

    public function breadcrumbs($category, $class = 'bcrumbs', &$parents = '')
    {
        $ul = "<ul class=\"$class\"><li>";
        if($category === null){
            return $ul.'<a href="'.url('/').'" >Acasa</a></li></ul>';
        }
        if($category->parent == 0){
            return $ul.'<a href="'.url('/').'" >Acasa</a></li><li><a href="'.url('categorie/'.$category->id.'/'.str_slug($category->name)).'" >'.$category->name.'</a></li></ul>';
        }

        $parent = $this->category->select('id','name','parent')->find($category->parent);
        $slug = str_slug($parent->name);
        $parents = "<li><a href=\"".url('categorie/'.$parent->id.'/'.$slug)."\">".$parent->name."</a></li>".$parents;
        $this->breadcrumbs($parent,$class,$parents);

        return $ul.'<a href="'.url('/').'" >Acasa</a></li>'.$parents.'<li><a href="'.url('categorie/'.$category->id.'/'.str_slug($category->name)).'" >'.$category->name.'</a></li></ul>';
    }

    public function priceWithoutVAT($price)
    {
        if(empty($price) || !is_numeric($price)){
            return false;
        }

        $price = (float)$price;
        $vat = (int)config('cart.tax');
        $priceNoVAT = $price / (($vat / 100)+1);

        return number_format($priceNoVAT,2,'.','');
    }

    public function getSubcategories( $parentId, &$subcategoriesArray = [] )
    {
        if( ! Schema::hasColumn($this->category->getTable(), 'parent') ){
            return $subcategoriesArray;
        }
        $subcategories = $this->category->where('parent', $parentId)->get();
        if($subcategories->isEmpty() === false){
            foreach($subcategories as $subcategory){
                $subcategoriesArray[] = $subcategory->id;
                $this->getSubcategories($subcategory->id, $subcategoriesArray);
            }
        }

        return $subcategoriesArray;
    }

    public function categoryModel()
    {
        return $this->category;
    }

    public function productModel()
    {
        return $this->items;
    }

    public function singleProduct($productId)
    {
        // TODO: Implement singleProduct() method.
    }

    public function categoryProducts($categoryId,
                                     $subcategoryProducts = true,
                                     $limit = null,
                                     $paginate = 20,
                                     array $orderBy = ['created_at'=>'asc'])
    {
        $categoryId = (int)$categoryId;
        $query = $this->items->newQuery();
        $query->where('visible',1);
        if( $subcategoryProducts === true ){
            $whereIn = $this->getSubcategories($categoryId);
            $whereIn[] = $categoryId;
            $query->whereIn('category_id',$whereIn);
        }else{
            $query->where('category_id', $categoryId);
        }

        foreach ($orderBy as $field => $direction){
            $direction = ( in_array($direction, ['asc','desc']) )? $direction : 'asc';
            $query->orderBy($field, $direction);
        }

        if( $limit !== null && is_int($limit) ) {
            $query->take( $limit )->get();
        }else{
            $query->paginate( (int)$paginate );
        }

        return $query;
    }

    public function allProducts( $paginate = 20, $orderBy = 'created_at', $direction = 'asc')
    {
        $items = $this->items->orderBy($orderBy, $direction)->paginate((int)$paginate);
        return $items;
    }

    public function randomCategoryProducts($categoryId, $limit = null, $skipProductId = null, $subcategoryProducts = true)
    {
        // TODO: Implement randomCategoryProducts() method.
    }

    public function randomProducts($limit = null)
    {
        // TODO: Implement randomProducts() method.
    }

    public function existingCategories()
    {
        // TODO: Implement existingCategories() method.
    }

    public function validCategory($categoryId)
    {
        // TODO: Implement validCategory() method.
    }

}