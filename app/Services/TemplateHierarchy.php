<?php

namespace App\Services;

use App\Models\Theme;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class TemplateHierarchy
{
    /**
     * Finding template that matches the template hierarchy
     *
     * @param array $templates Array of templates to search, from most specific to most general
     * @param Theme $theme Theme to be used
     * @return string|null Template name found or null if not found
     */
    public static function locateTemplate(array $templates, Theme $theme): ?string
    {
        // Apply filter to modify template list
        $templates = apply_filters('template_hierarchy', $templates, $theme);

        // Check if theme is a child theme
        $isChildTheme = $theme->isChildTheme();
        $parentTheme = $isChildTheme ? $theme->getParentTheme() : null;

        // Search template in active theme
        foreach ($templates as $template) {
            // Check in active theme
            $templatePath = "themes.{$theme->folder_name}.views.{$template}";
            if (View::exists($templatePath)) {
                return apply_filters('template_include', $templatePath, $template, $theme);
            }

            // If theme is a child theme, check in parent theme
            if ($isChildTheme && $parentTheme) {
                $parentTemplatePath = "themes.{$parentTheme->folder_name}.views.{$template}";
                if (View::exists($parentTemplatePath)) {
                    return apply_filters('template_include', $parentTemplatePath, $template, $parentTheme);
                }
            }
        }

        return null;
    }

    /**
     * Getting template hierarchy for home page
     *
     * @return array
     */
    public static function getHomeTemplates(): array
    {
        return [
            'pages.home',
            'pages.index',
            'index'
        ];
    }

    /**
     * Getting template hierarchy for blog page
     *
     * @return array
     */
    public static function getBlogTemplates(): array
    {
        return [
            'pages.blog',
            'pages.archive',
            'archive',
            'index'
        ];
    }

    /**
     * Getting template hierarchy for category page
     *
     * @param string $categorySlug Category slug
     * @return array
     */
    public static function getCategoryTemplates(string $categorySlug): array
    {
        return [
            "pages.category-{$categorySlug}",
            'pages.category',
            'pages.archive',
            'archive',
            'index'
        ];
    }

    /**
     * Getting template hierarchy for tag page
     *
     * @param string $tagSlug Tag slug
     * @return array
     */
    public static function getTagTemplates(string $tagSlug): array
    {
        return [
            "pages.tag-{$tagSlug}",
            'pages.tag',
            'pages.archive',
            'archive',
            'index'
        ];
    }

    /**
     * Getting template hierarchy for single post page
     *
     * @param string $postSlug Post slug
     * @param string $postType Post type (default: 'post')
     * @return array
     */
    public static function getSingleTemplates(string $postSlug, string $postType = 'post'): array
    {
        return [
            "pages.{$postType}-{$postSlug}",
            "pages.{$postType}",
            'pages.single',
            'single',
            'index'
        ];
    }

    /**
     * Getting template hierarchy for static page
     *
     * @param string $pageSlug Page slug
     * @return array
     */
    public static function getPageTemplates(string $pageSlug): array
    {
        return [
            "pages.page-{$pageSlug}",
            'pages.page',
            'page',
            'index'
        ];
    }

    /**
     * Getting template hierarchy for search page
     *
     * @return array
     */
    public static function getSearchTemplates(): array
    {
        return [
            'pages.search',
            'search',
            'index'
        ];
    }

    /**
     * Getting template hierarchy for 404 page
     *
     * @return array
     */
    public static function get404Templates(): array
    {
        return [
            'pages.404',
            '404',
            'index'
        ];
    }
}
