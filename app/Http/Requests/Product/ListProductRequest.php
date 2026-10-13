<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ListProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page' => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:500'],
            'search' => ['sometimes', 'nullable', 'string', 'max:100'],
            'category_id' => ['sometimes', 'nullable', 'integer', 'exists:categories,id'],
            'stock_status' => ['sometimes', 'nullable', 'string', 'in:all,in_stock,low_stock,out_of_stock'],
            'sort_by' => ['sometimes', 'string', 'in:created_at,name,sku,stock,purchase_price,selling_price'],
            'sort_order' => ['sometimes', 'string', 'in:asc,desc'],
            'start_date' => ['sometimes', 'nullable', 'date'],
            'end_date' => ['sometimes', 'nullable', 'date'],
        ];
    }

    public function page(): int
    {
        return max(1, (int) $this->query('page', 1));
    }

    public function perPage(): int
    {
        return min(500, max(1, (int) $this->query('per_page', 10)));
    }

    public function search(): ?string
    {
        $val = $this->query('search');

        return ($val !== null && trim($val) !== '') ? trim($val) : null;
    }

    public function categoryId(): ?int
    {
        $val = $this->query('category_id');

        return ($val !== null && $val !== '') ? (int) $val : null;
    }

    public function stockStatus(): string
    {
        return (string) $this->query('stock_status', 'all');
    }

    public function sortBy(): string
    {
        return (string) $this->query('sort_by', 'created_at');
    }

    public function sortOrder(): string
    {
        return strtolower((string) $this->query('sort_order', 'desc')) === 'asc' ? 'asc' : 'desc';
    }

    public function startDate(): ?string
    {
        $val = $this->query('start_date');

        return ($val !== null && trim($val) !== '') ? trim($val) : null;
    }

    public function endDate(): ?string
    {
        $val = $this->query('end_date');

        return ($val !== null && trim($val) !== '') ? trim($val) : null;
    }
}
