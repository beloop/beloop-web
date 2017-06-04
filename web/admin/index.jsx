import React from 'react';
import ReactDOM from 'react-dom';
import { IntlProvider } from 'react-intl';
import { Provider } from 'react-redux';
import { HashRouter as Router } from 'react-router-dom';

import ApiService from 'Services/http/api.service';
import store from './store';

import App from './App';

ApiService.get('translations', {}, { locale: 'en' }).then((response) => {
  ReactDOM.render(
    (
      <IntlProvider locale="en" messages={response.body}>
        <Provider store={store}>
          <Router>
            <App />
          </Router>
        </Provider>
      </IntlProvider>
    ),
    document.getElementById('beloop-admin'),
  );
});
