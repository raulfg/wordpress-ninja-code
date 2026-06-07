interface PortfolioACF {
    proyecto_url: string;
    proyecto_año: number;
    proyecto_cliente: string;
    proyecto_destacado: boolean;
    imagen_secundaria: {
        ID: number;
        url: string;
        width: number;
        height: number;
        alt: string;
    } | null;
}

interface PortfolioPost extends WordPressPost {
    acf: PortfolioACF;
}
