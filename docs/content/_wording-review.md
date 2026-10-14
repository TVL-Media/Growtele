# Wording review — premium positioning

Source: live site `listings.selectvia.com` (active theme folder `unnamed-file`, v2.11.0), extracted 2026-10-14.

**Rule:** avoid commodity terms ("bulk", "mass", "blast", "cheap"). Use *enterprise*, *high-volume*,
*at scale*, *large-scale* instead. Keep **one** subtle mention for search: the SMS page meta
description (read by search engines, not shown on the page). Replacements are kept close to the
original length so layouts don't shift.

Keep as is: "spam" in the Email deliverability line and in the legal anti-spam clauses
(Terms, Partner Terms). "Promotional SMS" / "Transactional SMS" are the official TRAI DLT categories.

## SMS page (`pages/sms/index.html` + `inc/content/defaults/products.php`)

| Location | Current | Proposed |
|---|---|---|
| Title tag | Bulk SMS \| Growtele | Enterprise SMS Platform \| Growtele |
| Meta description *(new — the one subtle mention)* | *(none)* | Enterprise SMS for OTPs, alerts and high-volume (bulk) campaigns — DLT-compliant, delivered in seconds with real-time reports. |
| Hero H1 | Reach Everyone on Any Mobile Phone With Bulk SMS | Reach Everyone on Any Mobile Phone With Enterprise SMS |
| Hero image alt | Bulk SMS delivery report dashboard with OTP alert | SMS delivery report dashboard with OTP alert |
| Journey H2 | The Right Bulk SMS for Every Touchpoint | The Right SMS for Every Touchpoint |
| Scale card H3 | Bulk Campaigns | Large-Scale Campaigns |
| Funnel H2 | Bulk SMS for every stage of your funnel | SMS for every stage of your funnel |
| Funnel intro | …the Growtele Bulk SMS API helps you win, engage, and keep customers for longer. | …the Growtele SMS API helps you win, engage, and keep customers for longer. |
| FAQ H2 | Everything You Need to Know About Our Bulk SMS | Everything You Need to Know About Our SMS Platform |
| FAQ lead | …enterprise volumes, DLT rules, and bulk campaigns. | …enterprise volumes, DLT rules, and large-scale campaigns. |
| FAQ Q5 | Can I run bulk SMS campaigns? | Can I run high-volume SMS campaigns? |

### SMS FAQ answers — content bug
All five answers on the live page are the same text (the Q1 answer is repeated). Proposed unique answers:

1. **How fast do SMS messages get delivered?** — Growtele delivers OTPs and alerts in seconds over direct operator routes, with live delivery reports for every message, in India and across 190+ countries.
2. **Does Growtele support OTP authentication?** — Yes. Send login, payment and sign-up OTPs through our API on priority routes, with templates pre-approved under DLT so codes arrive in seconds.
3. **Do you provide delivery reports and analytics?** — Yes. Track sent, delivered, failed and clicked messages in real time on one dashboard, and export reports or pull them through the API.
4. **Is Growtele SMS built for enterprise-scale volumes?** — Yes. Redundant infrastructure, throughput controls and smart routing handle millions of messages a day, including festive-season peaks.
5. **Can I run high-volume SMS campaigns?** — Yes. Upload contacts, pick a DLT-approved template, personalise each message and schedule large-scale campaigns, with DND scrubbing built in.

## Email page (`pages/email/index.html` + `products.php`)

| Location | Current | Proposed |
|---|---|---|
| Hero H1 (and section title) | Bulk Email & SMTP Delivery Straight to the Inbox. | High-Volume Email & SMTP Delivery Straight to the Inbox. |

## E-commerce page (`pages/ecommerce/index.html` + `industries.php`)

| Location | Current | Proposed |
|---|---|---|
| Channel card text | Send COD confirmations, shipping alerts, and delivery OTPs on DLT-compliant bulk SMS. | Send COD confirmations, shipping alerts, and delivery OTPs on DLT-compliant SMS. |

## Growinfinity.io page (`pages/growinfinity-io/index.html`)

| Location | Current | Proposed |
|---|---|---|
| "All Your Tools" tab button, panel H3 and image alt (×3) | Bulk SMS | SMS Campaigns |

## Shared navigation — mega menu (`template-parts/header/*`, every `pages/*/index.html` header, `inc/content/defaults/global.php`)

| Location | Current | Proposed |
|---|---|---|
| Products → SMS description | Bulk SMS for OTPs, alerts, and promotions, all DLT-compliant | Enterprise SMS for OTPs, alerts, and promotions, all DLT-compliant |

## Other notes
- **Home page title tag** reads "Selectvia Listings". That's the WordPress site title (Settings → General). Suggest: "Growtele — Omnichannel Messaging: SMS, WhatsApp, RCS, Email & Voice".
- **Most pages have no meta description.** Each `docs/content/<page>.md` shows `(none)` where it's missing.
