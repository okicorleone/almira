export default function roomsPage () {
  return {
    showAdd: false,
    showEdit: false,
    showDelete: false,

    formAdd:  { nama: '', lantai: '', deskripsi: '' },
    formEdit: { id: '',  nama: '', lantai: '', deskripsi: '' },
    del:      { id: '',  nama: '' },

    openAdd() {
      this.reset();
      this.formAdd = { nama: '', lantai: '', deskripsi: '' };
      this.showAdd = true;
    },
    openEdit(r) {
      this.reset();
      this.formEdit = {
        id:        r?.id ?? '',
        nama:      r?.nama ?? '',
        lantai:    r?.lantai ?? '',
        deskripsi: r?.deskripsi ?? r?.desc ?? ''
      };
      this.showEdit = true;
    },
    openDelete(r) {
      this.reset();
      this.del = { id: r?.id ?? '', nama: r?.nama ?? r?.name ?? '' };
      this.showDelete = true;
    },
    reset() {
      this.showAdd = this.showEdit = this.showDelete = false;
    },

    editAction()   { return `/admin/rooms/${this.formEdit.id}`; },
    deleteAction() { return `/admin/rooms/${this.del.id}`; },
  };
}

if (typeof window !== 'undefined') {
  window.roomsPage = roomsPage;
}
