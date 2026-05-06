# Instalar Lighthouse CLI
npm install -g lighthouse

# Auditoría completa del portfolio
lighthouse https://ninjatheme.com \
    --output=html \
    --output-path=./audit-lighthouse.html \
    --chrome-flags="--headless --no-sandbox" \
    --categories=performance,accessibility,best-practices,seo

# Solo la puntuación numérica (para CI/CD)
lighthouse https://ninjatheme.com \
    --output=json \
    --output-path=./audit.json \
    --chrome-flags="--headless --no-sandbox" \
    --quiet \
    --only-categories=performance
    
# Extraer la puntuación del JSON
cat audit.json | jq '.categories.performance.score * 100'
