// resources/js/schedule.js
export default function schedulePage() {
  return {
    // state filter
    filters: {
      room: '',
      month: '',
      year: '',
    },

    // reset filter
    resetFilters() {
      this.filters = { room: '', month: '', year: '' };
      // optional: kalau mau reload halaman tanpa filter
      window.location.href = '/admin/schedule';
    },

    // apply filter manual (kalau mau trigger lewat tombol)
    applyFilters() {
      const params = new URLSearchParams(this.filters).toString();
      window.location.href = `/admin/schedule?${params}`;
    },
  };
}

// supaya bisa dipanggil di x-data="schedulePage()"
if (typeof window !== 'undefined') {
  window.schedulePage = schedulePage;
}
