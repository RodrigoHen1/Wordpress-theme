# Million Dollar Pools — WordPress Theme

A luxury custom WordPress theme for showcasing the **World's Top 100 Swimming Pools** with affiliate booking integration.

---

## 📁 Theme File Structure

```
million-dollar-pools/
├── style.css                  ← Theme header + all CSS
├── functions.php              ← Theme setup, CPT, meta, AJAX
├── header.php                 ← Site header + nav
├── footer.php                 ← Footer + newsletter
├── index.php                  ← Homepage
├── single-pool.php            ← Individual pool profile page
├── archive-pool.php           ← Pool gallery/archive
├── page-top-100.php           ← Top 100 list (Template Name)
├── page.php                   ← Default page template
├── search.php                 ← Search results
├── 404.php                    ← Not found page
├── inc/
│   └── customizer.php         ← WordPress Customizer settings
└── assets/
    ├── css/                   ← (optional extra CSS files)
    ├── js/
    │   └── main.js            ← All theme JavaScript
    └── images/
        └── pool-placeholder.jpg  ← Fallback image (you must add this)
```

---

## 🚀 Installation on SiteGround + WordPress

### Step 1: Upload the Theme

**Option A — Via WordPress Admin (recommended):**
1. Zip the entire `million-dollar-pools/` folder
2. Go to **Appearance → Themes → Add New → Upload Theme**
3. Upload the zip → **Install Now** → **Activate**

**Option B — Via SiteGround File Manager:**
1. Log in to SiteGround's Site Tools
2. Go to **File Manager → public_html → wp-content → themes**
3. Upload the `million-dollar-pools/` folder

---

### Step 2: Required Plugins

Install these free plugins from **Plugins → Add New**:

| Plugin | Purpose |
|--------|---------|
| **Yoast SEO** or **Rank Math** | SEO meta tags, sitemaps |
| **WP Super Cache** | Performance caching |
| **Smush** | Image optimization |
| **Contact Form 7** | Contact page form |

---

### Step 3: Set Up Navigation Menus

1. Go to **Appearance → Menus**
2. Create a menu called **"Primary"** and assign it to the **Primary Navigation** location
3. Add pages: Home, Top 100, Gallery, About, Contact
4. Create 3 footer menus for the footer columns

---

### Step 4: Create Required Pages

Create these pages in **Pages → Add New**:

| Page Title | Template |
|-----------|----------|
| Home | Default (set as front page) |
| **Top 100** | **Top 100 Pools** (select in Page Attributes) |
| Gallery | Default |
| About | Default |
| Contact | Default |
| Privacy Policy | Default |
| Terms of Service | Default |
| Affiliate Disclosure | Default |

**Set homepage:** Go to **Settings → Reading** → set "Your homepage displays" to "A static page" → select **Home**.

---

### Step 5: Add Your Pools (Custom Post Type)

1. In the WordPress admin sidebar, click **Pools → Add New**
2. Fill in:
   - **Title** — Pool name (e.g. "Marina Bay Sands Infinity Pool")
   - **Featured Image** — Hero photo (use 1920×1080px minimum)
   - **Body content** — Full description, how to visit, what makes it special
   - **Excerpt** — Short summary (shown in cards and list)
3. Scroll to **"Pool Details & Ranking"** meta box:
   - Overall Rank (1–100)
   - Overall Score (e.g. 98.5)
   - Resort name, city, country
   - Architect, year built, dimensions
   - GPS coordinates (for Google Maps link)
4. In **"Affiliate Booking Link"**:
   - Paste your affiliate URL (Booking.com, Hotels.com, etc.)
   - Set button label (e.g. "Book at Marina Bay Sands")
5. In **"Score Breakdown"**:
   - Enter 0–100 scores for each category
6. Assign **Region** (Asia, Europe, etc.) and **Pool Type** (Infinity, Rooftop, etc.)
7. Click **Publish**

---

### Step 6: Configure Theme Settings

Go to **Appearance → MDP Settings**:
- Set the hero headline and subheading
- Enter the Featured Pool ID (the pool shown in the hero — find ID in URL when editing a pool)
- Edit the affiliate disclaimer text

Also go to **Appearance → Customize** for:
- Logo upload
- Gold accent color adjustment

---

### Step 7: Add a Placeholder Image

Add a fallback image at:
`wp-content/themes/million-dollar-pools/assets/images/pool-placeholder.jpg`

Use any 800×600 dark luxury image as a fallback for pools without a thumbnail.

---

### Step 8: Permalink Structure

Go to **Settings → Permalinks** and set to **"Post name"** (`/%postname%/`). Save. This gives you clean URLs like:
- `/pools/marina-bay-sands-infinity-pool/`
- `/top-100/`

---

## 🏊 How to Add Pool Gallery Images

The pool profile supports a gallery. To add gallery images:

1. Edit a Pool post
2. In the **content editor**, add a **Gallery block** (WordPress block editor)  
   OR add the custom field `_pool_gallery_images` with a comma-separated list of attachment IDs

For the custom field method (most reliable):
1. Enable **Custom Fields** via Screen Options (top-right of editor)
2. Add field: `_pool_gallery_images` → value: `123,456,789` (image IDs)

---

## 💰 Affiliate Link Setup

Each pool has an individual affiliate booking link set in the sidebar meta box.

**Recommended affiliate programs:**
- **Booking.com Partner Program** — https://www.booking.com/affiliate-program/
- **Hotels.com Affiliate** — via Commission Junction (CJ)
- **Agoda Partner** — https://partners.agoda.com
- **TripAdvisor** — via CJ or Impact

The booking button appears prominently in the pool profile sidebar with a gold CTA. The footer automatically displays your affiliate disclaimer.

---

## 🎨 Customization

### Colors
The theme uses CSS custom properties. Edit `style.css` line 10–30 to change:
```css
:root {
    --gold:        #C9A84C;  /* Main gold accent */
    --gold-light:  #E8CC80;  /* Light gold */
    --gold-dark:   #8B6914;  /* Dark gold */
    --black-rich:  #080808;  /* Page background */
}
```

### Fonts
Currently uses Google Fonts:
- **Cinzel** — display headings
- **Cormorant Garamond** — editorial subheadings  
- **Montserrat** — body text

To change, update the Google Fonts URL in `functions.php` and the `--font-*` variables in `style.css`.

---

## 📧 Newsletter Integration

The newsletter form submits via AJAX and stores emails in WordPress options by default.

To connect to Mailchimp / ConvertKit / etc.:
1. Edit `functions.php`
2. Find `function mdp_newsletter_signup()`
3. Add your email platform API call after the subscriber is stored

---

## ⚡ SiteGround Performance Tips

1. Enable **SiteGround SuperCacher** (Level 3)
2. Enable **Cloudflare** from Site Tools
3. Use **Smush** to compress all pool images
4. Set images to use **WebP** format
5. Enable **Lazy Loading** (already in theme HTML)

---

## 🔍 SEO

The theme automatically outputs:
- **Structured data** (Schema.org `TouristAttraction`) on each pool page
- Proper `title-tag` support
- `og:image` via Featured Image
- Breadcrumbs on pool profiles

Install **Rank Math** or **Yoast** for full sitemap + meta control.

---

## 📋 Taxonomy Slugs (for URL filters)

Set up these taxonomy terms in **Pools → Regions** and **Pools → Pool Types**:

**Regions** (slugs): `asia`, `europe`, `americas`, `middle-east`, `oceania`, `africa`

**Pool Types** (slugs): `infinity`, `rooftop`, `overwater`, `natural`, `underground`, `lagoon`, `olympic`

---

## 🛍️ Future: WooCommerce Merch

When ready to add merch:
1. Install WooCommerce
2. The theme includes basic WooCommerce compatibility CSS
3. Add a "Shop" page to the navigation menu
4. WooCommerce's default templates will inherit the dark theme colors

---

## 📞 Support

Theme developed for Million Dollar Pools. For customizations, contact your developer with reference to this README.
