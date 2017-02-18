# === T3v DataMapper Configuration ===

plugin {
  tx_t3vdatamapper {
    persistence {
      enableAutomaticCacheClearing = 1

      updateReferenceIndex = 1

      # storagePid = {$plugin.tx_t3vdatamapper.persistence.storagePid}
    }

    view {
      layoutRootPath = {$plugin.tx_t3vdatamapper.view.layoutRootPath}

      templateRootPath = {$plugin.tx_t3vdatamapper.view.templateRootPath}

      partialRootPath = {$plugin.tx_t3vdatamapper.view.partialRootPath}
    }

    settings {
      # ...
    }
  }
}