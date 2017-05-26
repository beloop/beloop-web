import React from 'react';
import ReactDOM from 'react-dom';
import { IntlProvider } from 'react-intl';
import { HashRouter as Router } from 'react-router-dom';

import ApiService from 'Services/http/api.service';

import App from './App';

ApiService.get('translations', {}, { locale: 'en' }).then((response) => {
  ReactDOM.render(
    (
      <IntlProvider locale="en" messages={response.body}>
        <Router>
          <App />
        </Router>
      </IntlProvider>
    ),
    document.getElementById('beloop-admin'),
  );
});
