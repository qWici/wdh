<template>
  <div class="suggestion">
    <button @click="submitSuggestion">
      <fa :icon="'magic'" fixed-width />
    </button>
  </div>
</template>

<script>
import swal from 'sweetalert2'

export default {
  name: 'WSuggestion',

  methods: {
    submitSuggestion () {
      swal({
        title: this.$t('submit_suggestion'),
        input: 'text',
        inputAttributes: {
          required: true
        },
        showCancelButton: true,
        confirmButtonText: this.$t('ok'),
        cancelButtonText: this.$t('cancel'),
        showLoaderOnConfirm: true,
        preConfirm: (text) => {
          if (text.length <= 0) {
            return swal({
              type: 'error',
              title: this.$t('error_alert_title'),
              text: this.$t('field_isnt_filled')
            })
          }
          return fetch(`/api/suggestion/add`,
            {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify({ 'text': text })
            })
            .then(response => {
              swal({
                type: 'success',
                title: this.$t('tnx_u_very_much')
              })
            })
            .catch(error => {
              swal.showValidationMessage(
                `Request failed: ${error}`
              )
            })
        },
        allowOutsideClick: () => !swal.isLoading()
      })
    }
  }
}
</script>

<style scoped lang="scss">
@import "../../sass/vars";

.suggestion {
  position: absolute;
  bottom: 30px;
  right: -70px;
  button {
    background: $gradient-green;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 4px 6px rgba(0,0,0,0.2);
    svg path {
      fill: #FFF;
    }
    &:hover {
      cursor: pointer;
      box-shadow: 0 4px 6px rgba(0,0,0,0.4);
      background: linear-gradient(45deg, #00b09b 0%, #96c93d 100%);
    }
  }
}
</style>
