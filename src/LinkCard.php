<?php
/**
 * Renders an escaped HTML link card with title, description, and thumbnail.
 */
class LinkCardRenderer {
    private string $url;
    private string $title;
    private string $description;
    private string $image;
    private bool $useNoFollow;

    public function __construct(
        string $url,
        string $title = '',
        string $description = '',
        string $image = '',
        bool $useNoFollow = true
    ) {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->useNoFollow = $useNoFollow;
    }

    public function render(): string {
        $escapedUrl = htmlspecialchars($this->url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedTitle = htmlspecialchars($this->title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedDesc = htmlspecialchars($this->description, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedImage = htmlspecialchars($this->image, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $relAttr = $this->useNoFollow ? ' rel="noopener noreferrer nofollow"' : '';

        $html = '<a href="' . $escapedUrl . '" target="_blank"' . $relAttr . ' class="link-card">';
        $html .= '<div class="link-card-thumbnail">';
        if ($this->image !== '') {
            $html .= '<img src="' . $escapedImage . '" alt="' . $escapedTitle . '" loading="lazy">';
        } else {
            $html .= '<div class="link-card-placeholder"></div>';
        }
        $html .= '</div>';
        $html .= '<div class="link-card-body">';
        $html .= '<h2 class="link-card-title">' . $escapedTitle . '</h2>';
        $html .= '<p class="link-card-description">' . $escapedDesc . '</p>';
        $html .= '<span class="link-card-domain">' . $this->extractDomain($escapedUrl) . '</span>';
        $html .= '</div>';
        $html .= '</a>';

        return $html;
    }

    private function extractDomain(string $url): string {
        $parsed = parse_url($url);
        return $parsed['host'] ?? '';
    }
}

/**
 * Creates a sample LinkCardRenderer with static content.
 *
 * @return LinkCardRenderer
 */
function createSampleLinkCard(): LinkCardRenderer {
    $url = 'https://mportal-aiyouxi.com.cn';
    $title = '爱游戏门户';
    $description = '探索爱游戏的精彩世界，获取最新游戏资讯、攻略和社区互动。';
    $image = '';

    return new LinkCardRenderer($url, $title, $description, $image);
}

/**
 * Renders and returns the HTML for a sample link card.
 *
 * @return string
 */
function renderSampleLinkCard(): string {
    $card = createSampleLinkCard();
    return $card->render();
}

// Example usage (uncomment to test):
// echo renderSampleLinkCard();