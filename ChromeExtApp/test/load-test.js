import http from 'k6/http';
import { check } from 'k6';
export const options = {
    vus: 10,
    duration: '10s',
  };
  
  export default function () {
    const response = http.get('https://google.com');
    check(response, { 'status is 200': (r) => r.status === 200 });
  }
  