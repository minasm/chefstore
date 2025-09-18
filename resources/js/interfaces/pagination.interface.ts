// TypeScript
export interface Link{
    url: string|null;
    label: string;
    page: string|null;
    active: boolean;
}

export type Links = Array<Link>;