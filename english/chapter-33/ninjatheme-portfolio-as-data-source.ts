// types/ninja-portfolio.ts

export interface NinjaProject {
  id: number;
  slug: string;
  title: { rendered: string };
  featured_image_url: string | null;
  meta: {
    client: string;
    year: number;
    technologies: string[];
    url: string;
  };
}

// lib/ninja-portfolio.ts

const WP_API = process.env.NEXT_PUBLIC_WP_API_URL;

export async function getProjects( perPage = 12 ): Promise<NinjaProject[]> {
  const res = await fetch(
    `${WP_API}/ninja-portfolio/v1/projects?per_page=${perPage}`,
    { next: { revalidate: 3600 } }
  );

  if ( ! res.ok ) {
    return [];
  }

  return res.json();
}

export async function getProjectBySlug( slug: string ): Promise<NinjaProject | null> {
  const res = await fetch(
    `${WP_API}/ninja-portfolio/v1/projects/${slug}`,
    { next: { revalidate: 3600 } }
  );

  return res.ok ? res.json() : null;
}
