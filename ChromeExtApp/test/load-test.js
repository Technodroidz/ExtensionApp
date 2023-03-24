import http from 'k6/http';
import { check } from 'k6';

export const options = {
  vus: 10, // number of virtual users
  duration: '10s', // test duration
};

export default function () {
  const response = http.get('https://example.com');
  check(response, { 'status is 200': (r) => r.status === 200 });
}
