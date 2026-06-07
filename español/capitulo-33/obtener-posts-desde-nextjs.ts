// types/wordpress.ts

export interface WPPost {
  id: number;
  date: string;
  slug: string;
  title: {
    rendered: string;
  };
  excerpt: {
    rendered: string;
  };
  content: {
    rendered: string;
  };
  yoast_head_json?: {
    title: string;
    description: string;
    og_image?: { url: string }[];
  };
}

export interface WPPage extends WPPost {
  parent: number;
  template: string;
}
