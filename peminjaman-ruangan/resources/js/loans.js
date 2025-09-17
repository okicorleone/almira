// resources/js/loans.js
export default function loansPage() {
  return {
    // state modal
    showApprove: false,
    showReject: false,
    rejectReason: '',
    target: { id: '', user: '', room: '' },

    // buka modal Approve
    openApprove(item) {
      this.reset();
      this.target = { 
        id: item?.id ?? '', 
        user: item?.user ?? '', 
        room: item?.room ?? '' 
      };
      this.showApprove = true;
    },

    // buka modal Reject
    openReject(item) {
      this.reset();
      this.target = { 
        id: item?.id ?? '', 
        user: item?.user ?? '', 
        room: item?.room ?? '' 
      };
      this.showReject = true;
    },

    // reset semua state
    reset() {
      this.showApprove = false;
      this.showReject = false;
      this.rejectReason = '';
      this.target = { id: '', user: '', room: '' };
    },

    // URL untuk form action
    approveAction() {
      return `/admin/loans/${this.target.id}/approve`;
    },
    rejectAction() {
      return `/admin/loans/${this.target.id}/reject`;
    },
  };
}

// supaya bisa dipanggil di x-data="loansPage()"
if (typeof window !== 'undefined') {
  window.loansPage = loansPage;
}
