export default () => ({
  showAdd: false,
  showEdit: false,
  showDelete: false,

  formAdd: { name: '', password: '', department: '', email: '' },
  formEdit: { id: null, name: '', department: '', email: '' },
  del: { id: null, name: '' },

  openAdd() {
    this.reset();
    this.showAdd = true;
  },
  openEdit(u) {
    this.reset();
    this.formEdit = {
      id: u.id,
      name: u.name ?? '',
      department: u.department ?? '',
      email: u.email ?? ''
    };
    this.showEdit = true;
  },
  openDelete(u) {
    this.reset();
    this.del = { id: u.id, name: u.name ?? '' };
    this.showDelete = true;
  },

  // URL mengikuti Route::resource('manageuser', ...)
  editAction() {
    return this.formEdit.id ? `/admin/manageuser/${this.formEdit.id}` : '#';
  },
  deleteAction() {
    return this.del.id ? `/admin/manageuser/${this.del.id}` : '#';
  },

  reset() {
    this.showAdd = this.showEdit = this.showDelete = false;
    this.formAdd  = { name: '', password: '', department: '', email: '' };
    this.formEdit = { id: null, name: '', department: '', email: '' };
    this.del      = { id: null, name: '' };
  }
});
