config {
  # --- Common ---

  xhtml_cleaning = 0

  disableAllHeaderCode = 1

  sendCacheHeaders = 0

  no_cache = 1

  contentObjectExceptionHandler = 0

  # --- i18n ---

  sys_language_uid = 0

  sys_language_isocode = en

  sys_language_isocode_default = en

  language = en

  locale_all = en_US.UTF-8

  sys_language_mode = ignore

  sys_language_overlay = 1

  linkVars = L(0-10)

  # --- URL / Links Handling ---

  absRefPrefix = /

  prefixLocalAnchors = 1

  # --- Misc ---

  # Deactivate Admin-Panel
  admPanel = 0

  # Deactivate extra debug information as comment in HTML code
  debug = 0

  # Disable prefix comments
  disablePrefixComment = 1

  # Spam prodection for email addresses
  spamProtectEmailAddresses         = 2
  spamProtectEmailAddresses_atSubst = (at)
}

page = PAGE
page {
  10 = FLUIDTEMPLATE
  10 {
    file = EXT:t3v_datamapper/Tests/Functional/Fixtures/Frontend/Template.html
  }
}

[globalVar = GP:L = 1]
config {
  sys_language_uid = 1
}
[end]