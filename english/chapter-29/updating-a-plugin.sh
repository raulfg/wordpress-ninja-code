# Update a specific plugin
composer update wpackagist-plugin/advanced-custom-fields

# Review the composer.lock diff to confirm what changed
git diff composer.lock

# Test locally
# If everything works, commit
git add composer.json composer.lock
git commit -m "chore: update Advanced Custom Fields to 6.2.8"

# Deploy to staging for validation
cd ../trellis
trellis deploy staging

# Validate on staging, then deploy to production
trellis deploy production
