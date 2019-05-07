export default {
    methods: {
        /*                Check                */
        isLastItem(item, list) {
            return item == list[list.length - 1]
        },
        isActiveModal(el) {
            return this.activeModal == el
        },
        smallScreenHelper() {
            if (!this.smallScreen) {
                this.infoSidebar = typeof this.getLs().infoSidebar !== 'undefined' ? this.getLs().infoSidebar : true
            }
        },

        /*                Buttons                */
        item_ops() {
            if (this.isBulkSelecting()) {
                return this.bulkItemsFilter.length == 0
            }

            return !this.selectedFile || this.IsLocked(this.selectedFile)
        },
        lock_btn() {
            return this.searchItemsCount == 0 ||
                this.isLoading ||
                !this.allItemsCount ||
                this.isBulkSelecting() && !this.bulkItemsCount
        },
        vis_btn() {
            return this.searchItemsCount == 0 ||
            this.isLoading ||
            !this.allItemsCount ||
            !this.isBulkSelecting() && this.selectedFileIs('folder') ||
            this.isBulkSelecting() && !this.bulkItemsCount
        },
        reset() {
            this.bulkSelect = false
            this.bulkSelectAll = false
            this.resetInput('bulkList', [])
            this.resetInput('searchFor')

            this.lazyModeIsOn()
                ? this.lazySelectFirst()
                : this.selectFirst()
        },

        /*                Resolve                */
        getFileName(name) {
            if (!this.config.hideFilesExt) {
                return name
            }

            return name.replace(/(.[^.]*)$/, '')
        },
        getFileSize(bytes) {
            if (bytes === 0) {
                return 'N/A'
            }

            let k = 1000
            let dm = 2
            let sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
            let i = Math.floor(Math.log(bytes) / Math.log(k))

            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ` ${sizes[i]}`
        },
        getExtension(name) {
            let index = name.lastIndexOf('.')

            return index > 0 ? name.substring(index + 1) : null
        },
        getIndexRange(start, end) {
            return Array(end - start + 1).fill().map((_, idx) => start + idx)
        },
        getElementByIndex(i) {
            return document.querySelector(`[data-file-index='${i}']`)
        },
        trans(key) {
            return this.translations[key]
        },

        /*                Toggle                */
        toggleOverlay() {
            EventHub.fire('toggle-overlay')
        },
        toggleModal(selector = null) {
            if (!selector) {
                // refresh if an image was edited
                if (this.activeModal == 'imageEditor_modal' && this.imageWasEdited) {
                    this.imageWasEdited = false
                    this.refresh()
                }

                this.resetInput('activeModal')
                return EventHub.fire('modal-hide')
            }

            this.activeModal = selector
            EventHub.fire('modal-show')
        },
        toggleLoading() {
            return this.isLoading = !this.isLoading
        },
        toggleInfoSidebar(e = null) {
            EventHub.fire('stopHammerPropagate')

            return this.infoSidebar = !this.infoSidebar
        },
        toggleUploadPanel() {
            return this.UploadArea = !this.UploadArea
        },
        toggleLoader(key, state) {
            return this[key] = state
        },

        /*                Loading                */
        noScroll(s) {
            let html = document.documentElement

            if (s == 'add') {
                return html.classList.add('no-scroll')
            }

            return html.classList.remove('no-scroll')
        },
        noFiles(s) {
            if (s == 'show') {
                this.infoSidebar = false
                this.toggleLoader('no_files', true)
                return EventHub.fire('no-files-show')
            }

            this.toggleLoader('no_files', false)
            EventHub.fire('no-files-hide')
        },
        noSearch(s) {
            if (s == 'show') {
                this.toggleLoader('no_search', true)
                return EventHub.fire('no-search-show')
            }

            this.toggleLoader('no_search', false)
            EventHub.fire('no-search-hide')
        },
        loadingFiles(s) {
            if (s == 'show') {
                this.toggleLoader('loading_files', true)
                return EventHub.fire('loading-files-show')
            }

            this.toggleLoader('loading_files', false)
            EventHub.fire('loading-files-hide')
        },
        ajaxError(s = true) {
            if (s) {
                this.infoSidebar = false
                this.toggleLoader('ajax_error', true)
                return EventHub.fire('ajax-error-show')
            }

            this.toggleLoader('ajax_error', false)
            EventHub.fire('ajax-error-hide')
        },

        /*                Helpers                */
        isFocused(item, e) {
            return this.$refs[item] && this.$refs[item].contains(e.target)
        },
        browserSupport(api) {
            return api in window
        },
        arrayFilter(arr) {
            return arr.filter((e) => e)
        },
        copyLink(path) {
            this.linkCopied = true
            this.$copyText(path)
        },
        resetInput(input, val = null) {
            if (Array.isArray(input)) {
                return input.forEach((e) => {
                    this[e] = val
                })
            }

            this[input] = val
        },
        clearDblSlash(str) {
            str = str.replace(/\/+/g, '/')
            str = str.replace(/:\//, '://')

            return str
        },
        onResize() {
            if (this.firstRun) {
                if (this.selectedFileIs('image')) {
                    this.isScrollable()
                }

                // 1087 = bulma is-hidden-touch
                if (document.documentElement.clientWidth < 1087) {
                    this.infoSidebar = false
                    this.smallScreen = true
                } else {
                    // hide active player modal
                    if (
                        this.isActiveModal('preview_modal') &&
                        (this.selectedFileIs('video') || this.selectedFileIs('audio')) &&
                        !this.player.fs &&
                        !this.player.playing
                    ) {
                        this.toggleModal()
                    }

                    this.toolBar = true
                    this.smallScreen = false
                    this.smallScreenHelper()
                }
            }
        },
        showNotif(msg, s = 'success', duration = 3) {
            let title

            switch (s) {
                case 'black':
                case 'danger':
                    title = 'Error'
                    duration = null
                    break
                case 'warning':
                    title = 'Warning'
                    break
                case 'info':
                    title = 'Info'
                    duration = 5
                    break
                default:
                    title = 'Success'
            }

            EventHub.fire('showNotif', {
                title: title,
                body: msg,
                type: s,
                duration: duration
            })
        }
    }
}
