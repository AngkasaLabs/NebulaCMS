<?php

namespace App\Helpers;

use App\Models\Menu;

class MenuHelper
{
    public static function render(string $location)
    {
        $menu = Menu::where('location', $location)
            ->where('is_active', true)
            ->with(['items' => function ($query) {
                $query->whereNull('parent_id')
                    ->orderBy('order')
                    ->with('children');
            }])
            ->first();

        if (!$menu) {
            return null;
        }

        return static::formatItems($menu->items);
    }

    protected static function formatItems($items)
    {
        if ($items->isEmpty()) {
            return [];
        }

        $result = [];
        foreach ($items as $item) {
            $result[] = static::formatItem($item);
        }

        return $result;
    }

    protected static function formatItem($item)
    {
        $formattedItem = [
            'id' => $item->id,
            'title' => $item->title,
            'url' => $item->url,
            'target' => $item->target,
            'type' => $item->type,
            'order' => $item->order,
            'child' => []
        ];

        if ($item->children->isNotEmpty()) {
            $formattedItem['child'] = static::formatItems($item->children);
        }

        return $formattedItem;
    }
}
