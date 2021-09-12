<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Category;
class MenuComposer
{
    protected $menu;
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
        $categorii = $this->category->select('id','name','parent')
            ->where('visible',1)
            ->orderBy('order')
            ->orderBy('name')
            ->get()
            ->toArray();

        $this->menu = '';
        $this->createMenu($categorii);
    }


    public function compose(View $view)
    {
        $view->with('meniu', $this->menu);
    }

    /**
     * @param     $categorii
     * @param int $parent
     */
    private function createMenu($categorii, $parent = 0)
    {
        foreach ($categorii as $categorie) {
            if($categorie['parent'] == $parent) {
                if( $this->parentHasChildren($categorie['id']) === true){
                    $this->menu .= "<li id=\"menu-item-7\" class=\"menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children\">
                                        <a href=\"" . url('categorie/' . $categorie['id'] . '/' . str_slug($categorie['name'])) . "\">{$categorie['name']}</a><ul class=\"sub-menu\">";

                    $this->menu .= $this->createMenu($categorii,$categorie['id']);
                    $this->menu .= "</ul></li>";
                }else {
                    $this->menu .= "<li id=\"menu-item-7\" class=\"menu-item menu-item-type-custom menu-item-object-custom\">
                                        <a href=\"" . url('categorie/' . $categorie['id'] . '/' . str_slug($categorie['name'])) . "\">{$categorie['name']}</a></li>";
                }
            }
        }
    }

    /**
     * @param $parentId
     * @return bool
     */
    private function parentHasChildren($parentId)
    {
        $parents = $this->category->pluck('parent')->toArray();
        if( in_array((int)$parentId, $parents)){
            return true;
        }
        return false;
    }
}