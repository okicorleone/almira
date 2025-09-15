// resources/js/loans.js
export default function loansPage() {
  return {
    showApprove: false,
    showReject: false,
    target: { id: '', user: '', room: '' },
    rejectReason: '',

    openApprove(item) {
      this.reset();
      this.target = { id: item?.id ?? '', user: item?.user ?? '', room: item?.room ?? '' };
      this.showApprove = true;
    },
    openReject(item) {
      this.reset();
      this.target = { id: item?.id ?? '', user: item?.user ?? '', room: item?.room ?? '' };
      this.showReject = true;
    },
    reset() {
      this.showApprove = this.showReject = false;
      this.rejectReason = '';
      this.target = { id: '', user: '', room: '' };
    },

    approveAction() { return `/admin/loans/${this.target.id}/approve`; },
    rejectAction()  { return `/admin/loans/${this.target.id}/reject`; },
  };
}

// supaya bisa dipanggil di x-data="loansPage()"
if (typeof window !== 'undefined') {
  window.loansPage = loansPage;
}
