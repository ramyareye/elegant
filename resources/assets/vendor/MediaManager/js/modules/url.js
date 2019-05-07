export default {
    methods: {
        getUrlWithoutQuery() {
            return location.href.replace(location.search, '')
        },
        clearUrlQuery() {
            history.replaceState(null, null, this.getUrlWithoutQuery())
        },
        getPathFromUrl() {
            return new Promise((resolve) => {
                if (!this.inModal) {
                    let path = new URLSearchParams(location.search)
                    this.folders = path.has('path') ? path.get('path').split('/') : []
                }

                return resolve()
            })
        },
        updatePageUrl() {
            if (!this.inModal) {
                let url = this.getUrlWithoutQuery()
                let folders = this.folders

                history.pushState(null, null,
                    folders.length
                        ? `${url}?path=${folders.join('/')}`
                        : url
                )
            }
        },
        urlNavigation(e) {
            if (!this.inModal) {
                this.getPathFromUrl().then(() => {
                    this.getFiles(this.folders)
                })
            }
        }
    }
}
