<?php
namespace src\Service\Formatter;

use src\Constant\Bootstrap as B;
use src\Service\Domain\WpPostService;
use src\Utils\Html;
use src\Utils\UrlGenerator;

final class ShortcodeFormatter
{
    public function __construct(
        private WpPostService $wpPostService
    ) {
    }

    public function parse(string $content): string
    {
        $content = $this->parseSpell($content);
        $content = $this->parseFeat($content);

        return $content;
    }

    private function parseSpell(string $content): string
    {
        return preg_replace_callback(
            '/\[spell\](.*?)\[\/spell\]/',
            function (array $matches): string {

                $title = trim($matches[1]);

                $post = $this->wpPostService->getByTitle(ucfirst($title), 'sort');

                if ($post === null) {
                    return htmlspecialchars($title);
                }

                return Html::getLink(
                    htmlspecialchars($title),
                    UrlGenerator::spell($post->post_name),
                    B::TEXT_DARK
                );
            },
            $content
        );
    }

    private function parseFeat(string $content): string
    {
        return preg_replace_callback(
            '/\[feat\](.*?)\[\/feat\]/',
            function (array $matches): string {

                $title = trim($matches[1]);

                $post = $this->wpPostService->getByTitle(ucfirst($title), 'feat');

                if ($post === null) {
                    return htmlspecialchars($title);
                }

                return Html::getLink(
                    htmlspecialchars($title),
                    UrlGenerator::feat($post->post_name)
                );
            },
            $content
        );
    }
}
