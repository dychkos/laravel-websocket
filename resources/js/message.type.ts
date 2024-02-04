export interface Message {
    id: number;
    body: string;
    createdAt: string;
    user: {
        name: string;
				id: number
    };
}
