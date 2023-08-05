import type { FetchOptions } from "ohmyfetch";

export const useApiFetch = (path: string, opts?: FetchOptions) => {
  const config = useRuntimeConfig();
  
  return $fetch(path, {
    baseURL: process.server
      ? config.public.BASE_API_BROWSER_URL
      : config.public.BASE_API_URL,
    headers: {
      Accept: "*/*",
      "Content-Type": "application/json",
      ...(opts!.headers && { ...opts!.headers }),
    },
    ...(opts && { ...opts }),
  });
};
