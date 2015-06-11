Purpose
=====

Strip is a base theme — a theme that is mostly substractive. It removes
significant markup bloat by extending template hooks, overriding .tpl files, 
and replacing a few key theme hooks.

It is recommended that you build custom themes as a child of Strip as 
opposed to building inside of Strip.



Recommended modules
=====

I'm opinionated. Here are a few good modules to install on just about
every Drupal site. If it isn't here, try to do without it. You may find 
Drupal is better as a framework.

- field_group
- jquery_update
- pathauto
- redirect (helpfully combines path_redirect and globalredirect)

(A few quality dependencies are installed alongside these modules: ctools, 
token, and potentially some others. We like these modules, too.)



Recommended configurations
=====

We also frequently forget our favorite configuration settings. So here are 
a few to remember:

- Set the administrative theme to Seven (and use it for editing content). Seven 
  most likely does it better than your theme will.
- Only administrators should typically be allowed to register accounts.
- If you're on the hook for hosting, be sure to configure the Available 
  Updates report to notify you about security updates.
- Before going to production, hide all messages from displaying.
- Be sure to enable Drupal's aggregation and caching tools before
  going to production.
