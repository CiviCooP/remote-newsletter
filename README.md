# Remote Newsletter

Allows subscriptions to CiviCRM entered from a remote drupal 7 site. Tuned to te specific ILGA situation, but maybe usable in other situations

## Requirements

* PHP v7.2+
* CiviCRM 5.20.2 (But works maybe on a lower version)
* Works together with the [Drupal Remote Newsletter module](https://github.com/CiviCooP/remote_newsletter)

## How it works.

### Subscription
- In CiviCRM a set of groups can be promoted to Remote Newsletter groups.
- On the remote site a subscription form is shown where someone who interested can leave his name and email, and can chose the newsletters.
- In CiviCRM a new contact is created. Some deduplication is done is someone with a known email address is interested. The newsletter groups are added to this contact.
- The groups can be used to for sending a newsletter.

### To unsubscribe.
- The newsletter must contain a unsupscription link. This can be created by adding the `{remotenewsletter.unsubscribe}` to the newsletter.
- The unsubscription link points to the newsletter on the remote site.

## Installation

Follow the standard installation procedure (a menu rebuild is a good idea)

## Setup

After installation a new setup screen is added as part of the Mailing menu. You can also access it with:
`https://<server>/civicrm/remotenewsletter/preferences`. Configure the following settings.

* What groups can be used for the mailing list (they must have the type 'Mailing').
* What deduplication rule must be used
* The link of unsubscription link on the remote site.
* The text that must be shown in the link

## Technical details

The unsubscription link is secured with a checkSum token.

## Known Issues

The unsubscription link does not expire (yet).


