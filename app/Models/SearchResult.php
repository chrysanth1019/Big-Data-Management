<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
    ];

    /**
     * Search for results based on query and category.
     * 
     * In a real application, this would query a database.
     * For this MVP, we're returning sample data.
     *
     * @param string $query
     * @param string|null $category
     * @return array
     */
    public static function search($query, $category = null): array
    {
        // For demo purposes, return sample results
        // In a real application, this would query a database
        $allResults = [
            [
                'id' => 1,
                'title' => '東京観光ガイド',
                'description' => '東京の人気観光スポットや隠れた名所について詳しくご案内します。',
                'category' => '旅行',
            ],
            [
                'id' => 2,
                'title' => '日本料理の基本',
                'description' => '和食の基礎から応用まで、伝統的な日本料理の作り方をご紹介。',
                'category' => '料理',
            ],
            [
                'id' => 3,
                'title' => '京都の古寺巡り',
                'description' => '歴史ある京都の寺院について、その歴史や見どころを詳しく解説します。',
                'category' => '旅行',
            ],
            [
                'id' => 4,
                'title' => '現代日本の文学作品',
                'description' => '現代日本の有名な作家とその代表作についての解説と分析。',
                'category' => '文学',
            ],
            [
                'id' => 5,
                'title' => '伝統的な日本の庭園設計',
                'description' => '日本庭園の様式と哲学、そして自宅で取り入れる方法について。',
                'category' => '文化',
            ],
            [
                'id' => 6,
                'title' => '東京観光ガイド',
                'description' => '東京の人気観光スポットや隠れた名所について詳しくご案内します。',
                'category' => '旅行',
            ],
            [
                'id' => 7,
                'title' => '東京観光ガイド',
                'description' => '東京の人気観光スポットや隠れた名所について詳しくご案内します。',
                'category' => '旅行',
            ],
            [
                'id' => 8,
                'title' => '東京観光ガイド',
                'description' => '東京の人気観光スポットや隠れた名所について詳しくご案内します。',
                'category' => '旅行',
            ],
            [
                'id' => 9,
                'title' => '東京観光ガイド',
                'description' => '東京の人気観光スポットや隠れた名所について詳しくご案内します。',
                'category' => '旅行',
            ],
            [
                'id' => 10,
                'title' => '東京観光ガイド',
                'description' => '東京の人気観光スポットや隠れた名所について詳しくご案内します。',
                'category' => '旅行',
            ],
            [
                'id' => 11,
                'title' => '東京観光ガイド',
                'description' => '東京の人気観光スポットや隠れた名所について詳しくご案内します。',
                'category' => '旅行',
            ],
            
        ];

        // Filter results based on query and category
        return array_filter($allResults, function($result) use ($query, $category) {
            $matchesQuery = stripos($result['title'], $query) !== false || 
                           stripos($result['description'], $query) !== false;
            
            $matchesCategory = !$category || $result['category'] === $category;
            
            return $matchesQuery && $matchesCategory;
        });
    }
}
