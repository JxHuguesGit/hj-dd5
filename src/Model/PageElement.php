<?php
namespace src\Model;

class PageElement
{
    private string $slug;
    private string $icon;
    private string $title;
    private string $description;
    private string $url;
    private int $order;
    private ?string $parentSlug = null;

    public function __construct(array $data) {
        $this->slug        = $data['slug']        ?? '';
        $this->icon        = $data['icon']        ?? '';
        $this->title       = $data['title']       ?? '';
        $this->description = $data['description'] ?? '';
        $this->url         = $data['url']         ?? '#';
        $this->order       = $data['order']       ?? 100;
        $this->parentSlug  = $data['parent']      ?? null;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getOrder(): int
    {
        return $this->order;
    }
    
    public function getParentSlug(): ?string
    {
        return $this->parentSlug;
    }
}
