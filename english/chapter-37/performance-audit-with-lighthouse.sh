# Install Lighthouse CLI
npm install -g lighthouse

# Full portfolio audit
lighthouse https://ninjatheme.com \
    --output=html \
    --output-path=./audit-lighthouse.html \
    --chrome-flags="--headless --no-sandbox" \
    --categories=performance,accessibility,best-practices,seo

# Numeric score only (for CI/CD)
lighthouse https://ninjatheme.com \
    --output=json \
    --output-path=./audit.json \
    --chrome-flags="--headless --no-sandbox" \
    --quiet \
    --only-categories=performance

# Extract score from JSON
cat audit.json | jq '.categories.performance.score * 100'
