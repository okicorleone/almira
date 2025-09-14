// resources/js/rooms.js
export default function roomsPage () {
  return {
    showAdd: false,
    showEdit: false,
    showDelete: false,

    formAdd:  { name: '', floor: '', description: '' },
    formEdit: { id: '',  name: '', floor: '', description: '' },
    del:      { id: '',  name: '' },

    openAdd() {
      this.reset();
      this.formAdd = { name: '', floor: '', description: '' };
      this.showAdd = true;
    },
    openEdit(r) {
      this.reset();
      this.formEdit = {
        id:          r?.id ?? '',
        nama:        r?.nama ?? '',
        lantai:       r?.lantai ?? '',
        deskripsi: r?.desc ?? r?.deskripsi ?? ''
      };
      this.showEdit = true;
    },
    openDelete(r) {
      this.reset();
      this.del = { id: r?.id ?? '', name: r?.name ?? '' };
      this.showDelete = true;
    },
    reset() {
      this.showAdd = this.showEdit = this.showDelete = false;
    },

    editAction()   { return `/admin/rooms/${this.formEdit.id}`; },
    deleteAction() { return `/admin/rooms/${this.del.id}`; },
  };
}
