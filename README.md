# Pronamic Order Referrer for WooCommerce

- [Introduction](#introduction)
- [Referrer policy](#referrer-policy)
- [Order attribution tracking](#order-attribution-tracking)
- [Links](#links)

## Introduction

This plugin keeps track of the referrer per WooCommerce order.

## Referrer policy

> The Referrer-Policy [HTTP header](https://developer.mozilla.org/en-US/docs/Glossary/HTTP_header) controls how much [referrer information](https://developer.mozilla.org/en-US/docs/Web/Security/Referer_header:_privacy_and_security_concerns) (sent with the [Referer](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Referer) header) should be included with requests. Aside from the HTTP header, you can [set this policy in HTML](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Referrer-Policy#integration_with_html).

Many web browsers use the `strict-origin-when-cross-origin` `Referrer-Policy` HTTP header by default:

> Send the origin, path, and querystring when performing a same-origin request. For cross-origin requests send the origin (only) when the protocol security level stays same (HTTPS→HTTPS). Don't send the Referer header to less secure destinations (HTTPS→HTTP).

## Order attribution tracking

In WooCommerce version `8.5.0` launched on January 8, 2024, the similar 'order attribution tracking' functionality has been launched:
https://woo.com/document/order-attribution-tracking/

## Links

- https://www.pronamic.eu/
- https://web.dev/articles/referrer-best-practices

[![Pronamic - Work with us](https://github.com/pronamic/brand-resources/blob/main/banners/pronamic-work-with-us-leaderboard-728x90%404x.png)](https://www.pronamic.eu/contact/)
