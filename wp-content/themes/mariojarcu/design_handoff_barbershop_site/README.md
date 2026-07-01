# Handoff: Mario Jarcu — Salon Concept (Barbershop Website)

## Overview
A four-page marketing website for **Mario Jarcu — Salon Concept**, a one-chair master
barbershop (Romanian-trained barber, Northampton UK). The site's job is to convert
word-of-mouth referrals into Booksy appointments: establish craft/credibility, show the
work, list services + pricing, and push to booking. The aesthetic is **dark, premium,
black-and-gold**, confident and uncluttered.

Pages: **Homepage**, **Services** (full price list), **Gallery**, **Booking** (Booksy embed).

## About the Design Files
The files in `pages/` are **design references created in HTML** — prototypes showing the
intended look, layout, and behavior. **They are not production code to copy directly.**

> ⚠️ Technical note: these `.html` files were authored in a component runtime and load a
> helper script (`pages/support.js`) with a `<x-dc>` wrapper. That wrapper is an artifact
> of the prototyping tool — **ignore it**. All the design information you need is the plain
> HTML markup with inline styles inside the `<x-dc>…</x-dc>` body. Open the files in a
> browser to see them render, or read the markup directly; the styling is 100% inline CSS,
> so every measurement, color, and font is visible in the source.

The task is to **recreate these designs as a WordPress theme**, using WordPress-appropriate
patterns (template files / blocks / a theme framework of your choice). Treat the HTML as the
source of truth for visual design; re-implement the structure idiomatically (e.g. header/footer
as theme parts, services & gallery as custom post types or ACF repeaters, etc.).

## Fidelity
**High-fidelity.** Final colors, typography, spacing, and interactions are all specified and
present in the source. Recreate the UI pixel-accurately. Exact hex values, font families, and
sizes are in the **Design Tokens** section below and inline in every element.

---

## Brand & Logo

- **Name:** Mario Jarcu — Salon Concept
- **Logo files** (in `assets/`):
  - `logo-lockup-dark.svg` — **horizontal lockup** (monogram + "MARIO JARCU" + justified
    "SALON CONCEPT" tagline), light artwork for **dark** backgrounds. Used in every header
    (height 46px) and footer (height 54px).
  - `logo-lockup-light.svg` — same lockup, dark artwork for **light** backgrounds.
  - `logo-v3-dark.svg` / `logo-v3-light.svg` — **stacked** lockup (monogram over wordmark
    over tagline). `logo-v3-light` is used faintly on the Booking page's loading tile.
  - `logo-v3-mark-dark.svg` / `logo-v3-mark-light.svg` — **monogram only** (M/J in a ring).
    Use for favicon / social avatar / small spaces.
- The monogram is an interlocked **M/J** inside a thin circle. In the wordmark, **"MARIO"**
  is ink/cream and **"JARCU"** is gold. The logo type is **Montserrat** (converted to
  outlines in the SVGs — there is no live font dependency in the logo).
- All logo SVGs are vector and recolor-safe; do not rasterize.

---

## Design Tokens

### Colors
| Token | Hex | Usage |
|---|---|---|
| Ink / page background | `#131313` | Primary dark background |
| Ink (deepest) | `#0E0E0E` | Footer background |
| Panel dark | `#1B1B1B` | Service cards, info strips |
| Cream (text on dark) | `#EDE7DC` | Body text & headings on dark |
| Cream heading | `#F4EFE6` | Large headings on dark |
| Cream section bg | `#EDE7DC` | About / Reviews / Services-list light sections |
| Ink text (on cream) | `#16140F` / `#1C1813` | Headings / body on cream |
| Muted body (on cream) | `#57514A` / `#54504A` | Paragraph text on cream |
| **Gold — solid** | `#C39A43` | Filled buttons, marquee & CTA-band background |
| Gold — bright (on dark) | `#CFA64E` / `#D4AC52` | "JARCU", accents, link underline, eyebrows |
| Gold — light (on dark) | `#E3C57C` | Hero eyebrow / light accents on dark |
| Gold — deep (on cream) | `#9C7A2C` / `#8C6E24` | "JARCU" & accents on cream |
| Dark-on-gold text | `#1A150B` | Text/icons sitting on a gold fill |
| Star on gold | `#6E5418` | Marquee separator stars |
| Hairline (on dark) | `rgba(237,231,220,0.1)` | Borders/dividers on dark |
| Hairline (on cream) | `rgba(28,24,19,0.1)` | Price-row dividers |
| Map pin | `#A33041`→ now gold accents; map marker uses gold | (see Location) |

> Note: the site was migrated from an earlier black-and-**maroon** palette to black-and-**gold**.
> If you find any stray `#7A2230`, `#A33041`, `#C0566A`, or `#D98591`, they are leftover maroon
> and should map to the gold equivalents above.

### Typography
Three families, loaded from Google Fonts:
- **Montserrat** (400/500/600/700/800) — primary. All headings, nav, body, buttons. Matches
  the logo. *(Display headings use 700–800/900-ish weights at large sizes.)*
- **Cormorant Garamond** (500/600/700, plus italic) — the editorial serif. Used for the
  About-section pull quote and the review blockquotes only. Sets the "upscale salon" tone.
- **Space Mono** (400/700) — small tracked labels / eyebrows / metadata (e.g. "BY APPOINTMENT
  · ONE CHAIR", section kickers, footer microtype).

Type patterns:
- **Hero H1:** Montserrat 900, `clamp(48px,7vw,104px)`, line-height ~0.94, letter-spacing
  -0.02em, UPPERCASE.
- **Section H2:** Montserrat 800, `clamp(34px,4.4vw,56px)`, UPPERCASE, letter-spacing -0.015em.
- **Eyebrow / kicker:** Space Mono, 11–12px, letter-spacing 0.40–0.42em, UPPERCASE, gold.
- **Body:** Montserrat 400, 15–19px, line-height 1.6–1.7.
- **Nav links:** Montserrat 500, 13px, letter-spacing 0.16em, UPPERCASE.
- **Pull quote / reviews:** Cormorant Garamond, italic 500 (quote) / 23px (reviews).

### Spacing & layout
- **Content max-width:** `1280px` (price-list & CTA bands use `1080px`), centered, `40px` side padding.
- **Section vertical padding:** `120px` top/bottom on major sections (`84px` on intro/hero bands).
- **Header height:** `78px`, sticky, `rgba(19,19,19,0.86)` + `backdrop-filter: blur(10px)`,
  bottom hairline.
- **Grid gaps:** 24px (cards), 48–80px (two-column splits).

### Radius, borders, shadows
- Card radius: `6px`; logo/preview panels `10–14px`; buttons `3px`.
- Borders: 1px hairlines using the token rgba values above.
- Shadows are used sparingly (lightbox image, About stat badge). Generally flat & matte.

### Buttons
- **Primary CTA:** background `#C39A43` (gold), text `#1A150B` (near-black), Montserrat 700,
  letter-spacing 0.12em, UPPERCASE, padding ~`18px 34px`, radius `3px`.
  Hover: background brightens to `#D4AC52` + `translateY(-1px)`.
- **Ghost button:** transparent, 1px cream border, cream text. Hover: fills cream, text → ink.

---

## Screens / Views

### 1. Homepage (`pages/Homepage.html`, preview `previews/Homepage.jpg`)
Sticky header → hero → marquee strip → about → services grid → reviews → location (map) → footer.

- **Header:** logo lockup (left), nav right: Location, Services, Gallery, **Book Now** (gold CTA).
- **Hero:** full-viewport, B&W shop photo (`assets/hero.jpg`) with dark gradient scrim
  (bottom→`#131313`). Eyebrow "BY APPOINTMENT · ONE CHAIR" (gold), H1 "THE CUT, DONE
  **PROPERLY.**" ("properly" in lighter gold), supporting paragraph, two buttons
  (primary "Book your chair", ghost "View services").
- **Marquee strip:** solid gold band, dark text, Space Mono tracked words ("SKIN FADES",
  "BEARD SCULPTING", "HOT TOWEL SHAVES", "RESTYLES") separated by deep-gold stars.
- **About:** cream section, two columns. Left: portrait (`assets/shave.jpg`, 4:5) with an
  ink "15+ years" stat badge overlapping bottom-left. Right: eyebrow "THE BARBER", H2
  "TRAINED IN ROMANIA. HONED ON THE FLOOR.", two paragraphs, and a **Cormorant italic**
  pull quote with a gold left-border.
- **Services grid (`#services`):** dark section. Header row: eyebrow + H2 "THE SERVICES" +
  "View full price list →" link (→ Services page). 3-col grid of 6 cards. Each card:
  image (3:2, hover zoom), title (UPPERCASE), gold price, one-line description. Card bg
  `#1B1B1B`, hairline border that turns gold + lifts `translateY(-4px)` on hover.
  Services & prices: Skin Fade £25, Cut & Beard £35, Hot Towel Shave £28, Cut & Style £22,
  Beard Sculpt £15, Restyle £30.
- **Reviews:** cream section, centered header (eyebrow "BOOKED ON REPUTATION", H2 "WHAT THEY
  SAY", 5-star line). 3 white review cards, each a Cormorant blockquote + Space Mono
  attribution. *(Review copy is placeholder — replace with real Google/Booksy reviews.)*
- **Location (`#location`):** dark section, two columns. Left: address, opening hours table,
  "Book an appointment" CTA. Right: **interactive Leaflet map** (CARTO dark tiles) with a
  gold circular marker + popup. *(See Interactions; address/hours are placeholder.)*
- **Footer:** logo lockup + tagline blurb, "Explore" links, "Get in touch" (Instagram,
  address, hours), bottom bar (© + city).

### 2. Services (`pages/Services.html`, `previews/Services.jpg`)
- Header (Services active) → intro band (eyebrow "SERVICES & PRICING", H1 "THE FULL LIST",
  faint B&W bg image) → **price list on cream** → gold CTA band → footer.
- Price list: two columns grouping **01 — Hair**, **02 — Beard**, **03 — Shaves & Rituals**,
  then a full-width **04 — Finishing & Add-ons** in 3 columns. Each row: name + (duration)
  sub-label + gold price, hairline divider, hover nudges row right + name → deep gold.
  Group labels are Space Mono kickers with a trailing hairline rule.
- Prices (guide): Skin Fade £25 / Cut & Style £22 / Scissor Cut £24 / Restyle £30 /
  Kids £16 / Buzz £15 · Beard Sculpt £15 / Trim & Line-up £12 / Cut & Beard £35 ·
  Hot Towel Shave £28 / Head Shave £20 · add-ons £6–£12.
- CTA band: gold, "READY WHEN YOU ARE.", ghost-style "Book your chair" (cream button → Booking).

### 3. Gallery (`pages/Gallery.html`, `previews/Gallery.jpg`)
- Header (Gallery active) → intro (eyebrow "THE WORK", H1 "GALLERY") → **masonry grid** →
  gold CTA band → footer.
- Grid: CSS `column-count:3`, `column-gap:18px`, tiles `break-inside:avoid`, 18px bottom
  margin. Each tile: image with hover zoom (`scale(1.05)`), a bottom gradient that fades in,
  and a Space Mono caption that slides up on hover. **Click opens a lightbox** (see below).
  Uses all shop photos in `assets/` (g1–g4, cut, detail, shave, steam, beard, hot-towel, hero).

### 4. Booking (`pages/Booking.html`, `previews/Booking.jpg`)
- Header (Book Now active) → intro (eyebrow "BOOKING", H1 "BOOK YOUR CHAIR") → info strip
  (Where / Hours / Good to know) → **Booksy embed** → footer.
- Embed: a cream rounded container (min-height 760px) holding an `<iframe>` to the Booksy
  widget. **Behind** the iframe is a fallback (faint stacked logo + "Loading…" copy + a
  "Book on Booksy" gold button) shown if the embed fails. A status row above reads "LIVE
  AVAILABILITY VIA BOOKSY" with an "Open in Booksy ↗" ghost button.
- **The Booksy URL is a placeholder** (`https://booksy.com/en-gb/`). Replace with Mario's
  real **embeddable widget URL** (Booksy → Boost → Website widget), not the public profile
  link (profiles block embedding).

---

## Interactions & Behavior
- **Sticky header** with blur backdrop; nav links have an animated gold underline
  (`width 0→100%`, 0.28s) on hover.
- **Primary buttons:** background → bright gold + `translateY(-1px)` on hover (0.2s).
- **Service cards:** lift `-4px`, border → gold, inner image `scale(1.05)` (0.3–0.4s ease).
- **Price rows:** `padding-left` nudge + name color → deep gold on hover.
- **Gallery tiles:** image zoom + gradient + caption slide-up on hover.
- **Gallery lightbox:** clicking a tile opens a fixed full-screen overlay (`rgba(10,10,10,0.94)`)
  with the full image, "Close ×" button; closes on overlay click, button click, or **Esc**.
  (Currently wired via a small JS handler; in WordPress use any lightbox lib or a few lines of JS.)
- **Map:** Leaflet 1.9.4 + CARTO `dark_all` tiles, `scrollWheelZoom:false`, custom gold
  `divIcon` marker, popup with shop name/address. Center is a **placeholder Northampton
  coordinate** — set the real lat/lng. (WordPress: reproduce with Leaflet, or a Google/
  Mapbox embed styled dark; keep the gold marker.)
- **Smooth scroll** for in-page anchors (`html{scroll-behavior:smooth}`); homepage nav
  Location/Services/Gallery are in-page or cross-page links.
- **Responsive:** layout is desktop-first with flex/grid + `clamp()` type. Two-column
  splits and 3-col grids should collapse to single column on mobile; the masonry column-count
  should drop to 2→1. (The prototypes don't include full mobile breakpoints — implement
  mobile per WordPress theme standards, preserving the hierarchy.)

## State Management
Minimal — this is a marketing site, not an app.
- Gallery lightbox: open/closed + current image src.
- Map: one-time init on mount.
- Booking: the Booksy widget manages its own booking state inside the iframe.
No global state, auth, or data fetching required (services/reviews can be static content or
WordPress CMS entries).

## Assets
All in `assets/` (copied from the shop's own photography — real, not stock):
- **Photos:** `hero.jpg`, `cut.jpg`, `shave.jpg`, `hot-towel.jpg`, `beard.jpg`, `detail.jpg`,
  `steam.jpg`, `g1.jpg`–`g4.jpg`. Mostly black-and-white / desaturated in use.
- **Logos:** `logo-lockup-dark.svg`, `logo-lockup-light.svg`, `logo-v3-dark.svg`,
  `logo-v3-light.svg`, `logo-v3-mark-dark.svg`, `logo-v3-mark-light.svg` (see Brand & Logo).
- **External:** Google Fonts (Montserrat, Cormorant Garamond, Space Mono); Leaflet 1.9.4
  (JS+CSS) and CARTO dark tiles for the map.
- `previews/` holds full-page JPG screenshots of each page for quick visual reference.

## Placeholders to replace before launch
1. **Booksy widget URL** (Booking page + all "Book on Booksy" links).
2. **Address & opening hours** (currently "12 High Street, Northampton, NN1 1AB" + sample hours).
3. **Map coordinates** (placeholder Northampton lat/lng + marker).
4. **Reviews** (placeholder quotes — swap for real ones).
5. **Instagram handle** (`@mario.jarcu` placeholder) and any other socials.
6. **Prices & durations** — confirm against Mario's actual menu.

## Files
```
design_handoff_barbershop_site/
├── README.md            ← this file
├── pages/
│   ├── Homepage.html    ← design reference (ignore <x-dc> wrapper + support.js)
│   ├── Services.html
│   ├── Gallery.html
│   ├── Booking.html
│   └── support.js       ← prototype runtime (NOT for production; lets the .html render)
├── assets/              ← logos (SVG) + shop photos (JPG)
└── previews/            ← full-page JPG screenshots of each page
```
