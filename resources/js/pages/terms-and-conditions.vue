<template>
  <div class="toc">
    <h1>
      Terms and conditions
    </h1>
    <article class="simple-text-page">
      <p>
        These terms and conditions ("Terms", "Agreement") are an agreement between Website Operator
        ("Website Operator", "us", "we" or "our") and you ("User", "you" or "your"). This Agreement sets forth the
        general terms and conditions of your use of the
        <a target="_blank" rel="nofollow" href="https://webdevhub.net">webdevhub.net</a> website and any of its
        products or services (collectively, "Website" or "Services").
      </p>
      <h2>Accounts and membership</h2>
      <p>
        If you create an account on the Website, you are responsible for maintaining the security of your account and
        you are fully responsible for all activities that occur under the account and any other actions taken in
        connection with it. We may, but have no obligation to, monitor and review new accounts before you may sign
        in and use our Services. Providing false contact information of any kind may result in the termination of
        your account. You must immediately notify us of any unauthorized uses of your account or any other breaches
        of security. We will not be liable for any acts or omissions by you, including any damages of any kind incurred
        as a result of such acts or omissions.
      </p>
      <h2>Backups</h2>
      <p>
        We are not responsible for Content residing on the Website. In no event shall we be held liable for any loss
        of any Content. It is your sole responsibility to maintain appropriate backup of your Content. Notwithstanding
        the foregoing, on some occasions and in certain circumstances, with absolutely no obligation, we may be able to
        restore some or all of your data that has been deleted as of a certain date and time when we may have backed up
        data for our own purposes. We make no guarantee that the data you need will be available.
      </p>
      <h2>Advertisements</h2>
      <p>
        During use of the Website, you may enter into correspondence with or participate in promotions of advertisers
        or sponsors showing their goods or services through the Website. Any such activity, and any terms, conditions,
        warranties or representations associated with such activity, is solely between you and the applicable
        third-party. We shall have no liability, obligation or responsibility for any such correspondence, purchase or
        promotion between you and any such third-party.
      </p>
      <h2>Links to other websites</h2>
      <p>
        Although this Website may link to other websites, we are not, directly or indirectly, implying any approval,
        association, sponsorship, endorsement, or affiliation with any linked website, unless specifically stated
        herein. We are not responsible for examining or evaluating, and we do not warrant the offerings of, any
        businesses or individuals or the content of their websites. We do not assume any responsibility or liability
        for the actions, products, services, and content of any other third-parties. You should carefully review the
        legal statements and other conditions of use of any website which you access through a link from this Website.
        Your linking to any other off-site websites is at your own risk.
      </p>
      <h2>Changes and amendments</h2>
      <p>
        We reserve the right to modify this Agreement or its policies relating to the Website or Services at any time,
        effective upon posting of an updated version of this Agreement on the Website. When we do, we will revise the
        updated date at the bottom of this page. Continued use of the Website after any such changes shall constitute
        your consent to such changes.
      </p>
      <h2>Acceptance of these terms</h2>
      <p>
        You acknowledge that you have read this Agreement and agree to all its terms and conditions. By using the
        Website or its Services you agree to be bound by this Agreement. If you do not agree to abide by the terms of
        this Agreement, you are not authorized to use or access the Website and its Services.
      </p>
      <h2>Using YouTube functionality</h2>
      <p>
        We use YouTube functionality. You can read the terms and conditions of its use
        <a href="https://www.youtube.com/t/terms" target="_blank">here</a>
      </p>
      <h2>Contacting us</h2>
      <p>If you have any questions about this Agreement, please <a href="mailto:dev.kucher@gmail.com">contact us</a>.</p>
      <p>This document was last updated on September 25, 2019</p>
    </article>
  </div>
</template>

<script>
export default {
  layout: 'inner',

  components: {},

  computed: {},

  data: () => ({}),

  methods: {
  }
}
</script>

<style scoped lang="scss">
@import "../../sass/elements/home";
@import "../../sass/elements/simple-text-page";
.toc {
  padding-bottom: 50px;
  margin-top: -20px;
  h1 {
    color: #fff;
  }
}
@media (max-width: 768px) {
  h1 {
    font-size: 36px;
  }
  h2 {
    font-size: 32px;
  }
}
</style>
