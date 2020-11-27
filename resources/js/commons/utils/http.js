/* Re-format the URL parameters for
 * readbility
 */
export function urlsafe(url, ...params) {
    return url.concat(params.join('/'), '/');
}

/* Transform dict (obj) data into string object
 * format.
 */
export function queryparams(data) {
    const params = Object.keys(data)
      .map((key) => {
          return `${key}=${encodeURIComponent(data[key])}`;
      })
      .join('&')
    ;
    return `?${params}`;
  }
  