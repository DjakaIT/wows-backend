<template>
  <div>
    <header>
      <nav>
        <Link href="/">Home</Link>
        <Link href="/wiki">Wiki</Link>
      </nav>
    </header>
  </div>
  <main>
    <!-- Page slot-->
    <slot />
  </main>
  <footer>
    <b-container>
      <b-row>
        <b-col>
          <ul>
            <li>
              <router-link :to="{ name: 'Faq' }">
                {{ $t('footer_link_faq') }}
              </router-link>
            </li>
            <li>
              <router-link :to="{ name: 'Imprint' }">
                {{ $t('footer_link_imprint') }}
              </router-link>
            </li>
            <li>
              <router-link :to="{ name: 'Privacy' }">
                {{ $t('footer_link_privacy') }}
              </router-link>
            </li>
            <li>
              <router-link :to="{ name: 'Contact' }">
                {{ $t('footer_link_contact') }}
              </router-link>
            </li>
          </ul>
        </b-col>
      </b-row>
      <b-row>
        <b-col>
          <p class="disclaimer">
            {{ $t('footer') }}
          </p>
        </b-col>
      </b-row>
    </b-container>
  </footer>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
