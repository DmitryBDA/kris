<template>
  <div>
    <div class="modal fade" id="modal-action-with-records" ref="modal_action_record">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Выбор действия</h4>
            <button type="button" class="close" data-dismiss="modal" ref="close_modal_action_records"
                    aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="">
            <form class="form-horizontal _form_action_record" :data-record-id="recordId">
              <div class="card-body">
                <p><strong>{{ dayWeek }}, {{ date }} г.</strong></p>
                <div class="form-group row">
                  <label class="col-3 col-form-label">Время</label>
                  <div class="col-9">
                    <input type="time" v-model="time" class="form-control">
                  </div>


                </div>
                <template v-if="statusRecord !== 4">

                  <div class="form-group row">
                    <label class="col-3 col-form-label">Услуга</label>
                    <div class="col-9">
                      <select v-model="selectedService" class="form-control _input_form_for_record">
                        <option v-for="item in services" :value="item.id">{{ item.name }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label">Фам. имя</label>
                    <div class="col-9">
                      <input type="text"
                             class="form-control input-lg add_name"
                             :class="{'is-invalid':errorValidate.name}"
                             @keyup="getDataAutocomplete()"
                             name="name"
                             v-model="name"
                             placeholder="Фамилия и имя"
                             autocomplete="off">
                      <small v-for="message in errorValidate.name" class="text-danger">{{ message }}</small>

                      <div v-if="isActiveSearch" class="panel-footer"
                           style="position: absolute;z-index: 1;">
                        <ul class="list-group">
                          <a href="#" @click.prevent="pasteName(name, phone)" class="list-group-item"
                             v-for="(name, phone) in search_data">{{ name }}</a>
                        </ul>
                      </div>
                    </div>


                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label">Телефон</label>
                    <div class="col-9">
                      <div class="input-group">
                        <input type="text"

                               placeholder="(999) 999-99-99"
                               name="phone"
                               v-model="phone"
                               class="form-control"
                               :class="{'is-invalid':errorValidate.phone}">

                        <div class="input-group-append">
                          <a v-if="phone" :href="'whatsapp://send?phone=+7' + phone" style="text-decoration: none"
                             class="input-group-text">
                            <i class="fa fa-whatsapp" aria-hidden="true"></i>
                          </a>
                          <a v-if="phone" :href="'tel:+7' + phone" style="text-decoration: none"
                             class="input-group-text">
                            <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <small v-for="message in errorValidate.phone" class="text-danger">{{ message }}</small>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label">Коммент</label>
                    <div class="col-9">
                    <textarea name="comment"
                              class="form-control"
                              rows="3"
                              v-model="comment"
                              placeholder="Введите текс сообщения"></textarea>
                    </div>
                  </div>

                  <!--                <div v-if="otherTimeRecords.length !== 0" class="form-group row">
                                    <label class="col-3 col-form-label">Также</label>
                                    <div class="col-9">
                                      <span style="display: block" v-for="item in otherTimeRecords">{{ item.date }} {{ item.time }}</span>
                                    </div>
                                  </div>-->

                </template>

                <div v-else class="form-group row">
                  <label class="col-3 col-form-label">Описание</label>
                  <div class="col-9">
                    <input type="text"
                           class="form-control input-lg add_name"
                           v-model="title">
                  </div>
                </div>

              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button v-if="statusRecord !== 2 && isEdit" @click.prevent="updateRecord()"
                        class="btn btn-success float-center mr-1">Сохранить
                </button>
                <button v-if="statusRecord === 2" @click.prevent="confirmRecord()" class="btn btn-info mr-1">
                  Подтвердить
                </button>
                <button v-if="statusRecord !== 1 && statusRecord !== 4" @click.prevent="cancelRecord()"
                        class="btn btn-info mr-1">Отменить
                </button>
                <button class="btn btn-danger float-right" @click.prevent="deleteRecord()">Удалить</button>
              </div>
              <!-- /.card-footer -->
            </form>
          </div>
        </div>
      </div>
    </div>
    <button style="display: none" data-toggle="modal" data-target="#modal-action-with-records"
            ref="open_modal_action_records"></button>
    <button style="display: none" type="button" class="btn btn-success swalDefaultSuccess"
            @click.prevent="alertSuccessAction(successTitleMessage)"
            ref="mess_about_success_action"></button>
  </div>
</template>

<script>

export default {
  props: ['dataRecord'],
  components: {

  },
  data: function () {
    return {
      recordId: null,
      time: null,
      dayWeek: null,
      date: null,
      selectedService: 1,
      services: null,
      name: null,
      title: '',
      phone: null,
      statusRecord: null,
      isEdit: true,
      isActiveSearch: false,
      search_data: [],
      Toast: null,
      comment: '',
      otherTimeRecords: [],
      errorValidate: '',
      successTitleMessage: ''
    }
  },
  watch: {
    dataRecord: function () {
      this.recordId = this.dataRecord.id
      this.time = this.dataRecord.time
      this.dayWeek = this.dataRecord.dayWeek
      this.date = this.dataRecord.date
      this.selectedService = this.dataRecord.service_id ? this.dataRecord.service_id : 1
      this.name = this.dataRecord.user ? this.dataRecord.user.surname + ' ' + this.dataRecord.user.name : ''
      this.title = this.dataRecord.title
      this.phone = this.dataRecord.user ? this.dataRecord.user.phone : ''
      this.statusRecord = this.dataRecord.status
      this.comment = this.dataRecord.comment
      //this.otherTimeRecords = this.dataRecord.otherTimeRecords
      this.errorValidate = []
      this.$refs.open_modal_action_records.click()

    },
  },
  mounted() {
    // this.Toast = Swal.mixin({
    //   toast: true,
    //   position: 'top-end',
    //   showConfirmButton: false,
    //   timer: 3000
    // });
    axios.get('/api/admin/services', {
      // headers: {'Authorization': 'Bearer fjheu834jd740dk3j59djh3948dk3498e'},
    })
      .then((response) => {
        this.services = response.data;
      })
  },
  computed: {},
  methods: {

  }
}

</script>
