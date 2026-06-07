interface WordPressImageSize {
    source_url: string;
    width: number;
    height: number;
}

interface WordPressMedia {
    source_url: string;
    alt_text: string;
    media_details: {
        width: number;
        height: number;
        sizes: Record<string, WordPressImageSize>;
    };
}

function getImageSrc( media: WordPressMedia, preferredSize: string = 'large' ): string {
    return media.media_details.sizes[preferredSize]?.source_url ?? media.source_url;
}
